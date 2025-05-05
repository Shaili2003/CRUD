<?php
session_start();
include('db.php'); 

if (!isset($_SESSION['email'])) {
    echo "Please log in to update your profile.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['id'] ?? '';
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if (empty($userId) || empty($firstName) || empty($lastName) || empty($email)) {
        echo "All fields are required.";
        exit();
    }

    $profilePhoto = '';
    
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_photo']['tmp_name'];
        $fileName = basename($_FILES['profile_photo']['name']);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "Invalid file format. Only JPG, JPEG, PNG, and GIF files are allowed.";
            exit();
        }

        $newFileName = uniqid('profile_', true) . '.' . $fileExtension;
        $uploadPath = 'uploads/' . $newFileName;

        if (!move_uploaded_file($fileTmpPath, $uploadPath)) {
            echo "Error uploading the profile picture.";
            exit();
        }
        $profilePhoto = $uploadPath;
    }

    try {
        $updateQuery = "UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, phone = :phone";

        if (!empty($profilePhoto)) {
            $updateQuery .= ", profile_photo = :profile_photo";
        }
        
        $updateQuery .= " WHERE id = :id";

        $stmt = $conn->prepare($updateQuery);
        $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

        if (!empty($profilePhoto)) {
            $stmt->bindParam(':profile_photo', $profilePhoto, PDO::PARAM_STR);
        }

        $stmt->execute();

        // echo "Profile updated successfully.";
        header('Location: profile.php');
    } catch (PDOException $e) {
        echo "Error updating profile: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
