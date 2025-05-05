<?php
error_reporting(E_ALL);
session_start();
include('db.php');

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
    echo "<p style='text-align:center;'>Please <a href='index.php'>log in</a> to view your profile.</p>";
    exit();
}

$email = $_SESSION['email']; 
$user_id = $_SESSION['user_id'];

// Fetch user details
$query = "SELECT id, first_name, last_name, email, phone, profile_photo FROM users WHERE email = :email";
$stmt = $conn->prepare($query);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "<p style='text-align:center;'>User not found.</p>";
    exit();
}

$profilePicture = !empty($user['profile_photo']) ? $user['profile_photo'] : 'uploads/default-profile.png'; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #f9fafb;
            font-family: 'Helvetica Neue', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .profile-page {
            max-width: 480px;
            margin: 40px auto;
            padding: 30px;
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .profile-page img {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 5px solid #34c0eb;
        }
        .profile-page h2 {
            font-size: 26px;
            color: #2d3436;
            margin-bottom: 15px;
        }
        .profile-details {
            background-color: #f4f7fb;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        .profile-details p {
            margin: 12px 0;
            font-size: 16px;
            color: #444;
        }
        .profile-details strong {
            color: #2c3e50;
            font-weight: 600;
        }
        .actions {
            margin-top: 25px;
        }
        button {
            padding: 12px 20px;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            font-size: 16px;
            margin: 8px;
            transition: all 0.3s;
        }
        .edit-btn {
            background-color: #3498db;
            color: white;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }
        .edit-btn:hover {
            background-color: #2980b9;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            width: 60%;
            max-width: 600px;
            margin: 15% auto;
            text-align: left;
        }
        .modal-content h3 {
            text-align: center;
            color: #2c3e50;
        }
        .modal-content form {
            display: flex;
            flex-direction: column;
        }
        .modal-content input {
            margin-bottom: 15px;
            padding: 14px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .close {
            float: right;
            cursor: pointer;
            font-size: 20px;
            color: #333;
        }
    </style>
</head>
<body>

<?php include('nav.php'); ?>

<div class="profile-page">
    <img id="profile-img" src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture">
    <h2><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h2>
    <div class="profile-details">
        <p><strong>ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
    </div>
    <div class="actions">
        <button class="edit-btn" onclick="openModal()">Edit Info</button>
        <button class="delete-btn" onclick="deleteUser()">Delete Account</button>
    </div>
</div>

<div id="edit-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Edit Profile</h3>
        <form id="edit-form" enctype="multipart/form-data" method="POST" action="update.php">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <label>First Name</label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            <label>Last Name</label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <label>Phone</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            <label>Profile Picture</label>
            <input type="file" name="profile_photo">
            <button type="submit" class="save-btn">Save Changes</button>
        </form>
    </div>
</div>

<?php include('footer.php'); ?>

<script>
    function openModal() {
        document.getElementById("edit-modal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("edit-modal").style.display = "none";
    }

    function updateProfile() {
        let formData = new FormData(document.getElementById("edit-form"));

        fetch("update_profile.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            if (!data.includes("Error")) {
                location.reload();
            }
        })
        .catch(error => console.error("Error updating profile:", error));
    }

    function deleteUser() {
        if (confirm("Are you sure you want to delete your account? This action cannot be undone!")) {
            fetch("delete.php", {
                method: "POST",
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "success") {
                    alert("Account deleted successfully.");
                    window.location.href = "index.php"; 
                } else {
                    alert(data);
                }
            })
            .catch(error => console.error("Error deleting account:", error));
        }
    }
</script>

</body>
</html>
