<?php
include('db.php'); 

$registerError = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {

    $firstName = isset($_POST['register_first_name']) ? $_POST['register_first_name'] : '';
    $lastName = isset($_POST['register_last_name']) ? $_POST['register_last_name'] : '';
    $email = isset($_POST['register_email']) ? $_POST['register_email'] : '';
    $password = isset($_POST['register_password']) ? $_POST['register_password'] : '';
    $phone = isset($_POST['register_phone']) ? $_POST['register_phone'] : '';
    $confirmPassword = isset($_POST['register_confirm_password']) ? $_POST['register_confirm_password'] : '';

    if ($password !== $confirmPassword) {
        $registerError = "Passwords do not match!";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        $profilePhoto = NULL;
        if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
            $photoTmpPath = $_FILES['profile_photo']['tmp_name'];
            $photoName = uniqid() . '_' . $_FILES['profile_photo']['name'];
            $photoDestination = 'uploads/' . $photoName; 

            if (move_uploaded_file($photoTmpPath, $photoDestination)) {
                $profilePhoto = $photoDestination;
            }
        }

        if ($profilePhoto) {
            $query = "INSERT INTO users (first_name, last_name, email,phone, password, profile_photo) 
                      VALUES (:first_name, :last_name, :email, :phone, :password, :profile_photo)";
            $stmt = $conn->prepare($query);

            try {
                $stmt->execute([
                    ':first_name' => $firstName, 
                    ':last_name' => $lastName,
                    ':email' => $email, 
                    ':phone' => $phone,
                    ':password' => $hashedPassword, 
                    ':profile_photo' => $profilePhoto
                ]);
                header("Location: index.php");
                exit();
            } catch (PDOException $e) {
                $registerError = "Error: " . $e->getMessage();
            }
        } else {
            $registerError = "Please upload a valid profile picture.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #fc5c7d, #6a82fb);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .register-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #ff6b6b;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #d45d5d;
        }
        .error-message {
            color: red;
            font-size: 14px;
        }
        p {
            margin-top: 15px;
        }
        a {
            color: #6a82fb;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Create an Account</h2>
        <?php if ($registerError): ?>
            <p class="error-message"><?php echo $registerError; ?></p>
        <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
            <input type="text" name="register_first_name" placeholder="First Name" required>
            <input type="text" name="register_last_name" placeholder="Last Name" required>
            <input type="email" name="register_email" placeholder="Email" required>
            <input type="text" name="register_phone" placeholder="phone" register>
            <input type="password" name="register_password" placeholder="Password" required>
            <input type="password" name="register_confirm_password" placeholder="Confirm Password" required>
            <input type="file" name="profile_photo" placeholder="Choose the picture" required>
            <button type="submit" name="register">Register</button>
    </form>

        <p>Already have an account? <a href="index.php">Login Here</a></p>
    </div>
</body>
</html>
