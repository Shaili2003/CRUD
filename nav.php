<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('db.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$email = $_SESSION['email']; 

// Fetch user details
$query = "SELECT id, first_name, last_name, email, phone, profile_photo FROM users WHERE email = :email";
$stmt = $conn->prepare($query);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!isset($_SESSION['email'])) {
    $username = "Guest";
    $full_name = "Guest User";
    $profile_photo = "default-profile.png"; 
} else {

    
    $full_name = isset($user['first_name']) && isset($user['last_name']) 
        ? $user['first_name'] . " " . $user['last_name'] 
        : "User";

    // Set profile image from database if available
    $profile_image = isset($user['profile_photo']) && !empty($user['profile_photo']) 
        ? $user['profile_photo'] 
        : "default-profile.png"; 
}
?>

<header>
    <div class="header-container">
        <div class="logo">
            <a href="home.php">Web Application</a>
        </div>
        <nav class="navigation">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </nav>
        <div class="user-profile">
            <div class="profile-info">
                <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile">
                <span class="username">@<?php echo htmlspecialchars($full_name); ?></span>
            </div>
            <div class="profile-dropdown">
                <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile">
                <p class="profile-name"><?php echo htmlspecialchars($full_name); ?></p>
                <button onclick="window.location.href='profile.php';">View Profile</button>
                <button onclick="window.location.href='logout.php';">Sign Out</button>
            </div>
        </div>
    </div>
</header>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    header {
        width: 100%;
        background: linear-gradient(135deg, #4b6cb7, #182848);
        padding: 15px 0;
        color: #fff;
    }

    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 90%;
        margin: auto;
    }

    .logo a {
        font-size: 26px;
        font-weight: bold;
        text-decoration: none;
        color: #fff;
    }

    .navigation ul {
        list-style: none;
        display: flex;
    }

    .navigation ul li {
        margin: 0 15px;
    }

    .navigation ul li a {
        text-decoration: none;
        color: #fff;
        font-size: 18px;
        transition: color 0.3s;
    }

    .navigation ul li a:hover {
        color: #a1c4fd;
    }

    .user-profile {
        position: relative;
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .profile-info {
        display: flex;
        align-items: center;
        background: #fff;
        padding: 8px 12px;
        border-radius: 20px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-info img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .username {
        font-weight: bold;
        font-size: 16px;
        color: #333;
    }

    .profile-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        width: 220px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        z-index: 10;
    }

    .profile-dropdown img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        margin-bottom: 10px;
    }

    .profile-name {
        color: #333;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .profile-dropdown button {
        margin-top: 10px;
        padding: 8px 12px;
        width: 100%;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: background 0.3s;
    }

    .profile-dropdown button:hover {
        background: #0056b3;
    }

    .user-profile:hover .profile-dropdown {
        display: block;
    }
</style>
