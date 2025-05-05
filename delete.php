<?php
session_start();
include('db.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Error: You must be logged in to delete your account.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Delete user from database
$query = "DELETE FROM users WHERE id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

if ($stmt->execute()) {
    session_destroy();
    echo "success";
} else {
    echo "Error: Unable to delete account.";
}
?>
