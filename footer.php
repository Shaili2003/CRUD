<?php
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['username'])) {
    $username = "Guest";
    $profile_image = "default-profile.png";
} else {
    $username = $_SESSION['username'];
    $profile_image = "profile-images/" . $username . ".png";
}
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Arial', sans-serif;
    }

    footer {
        width: 100%;
        background: linear-gradient(135deg, #333, #444);
        color: white;
        text-align: center;
        padding: 15px 0;
        position: fixed;
        bottom: 0;
        left: 0;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
    }

    .footer-container {
        max-width: 1100px;
        margin: 0 auto;
    }

    .footer-social {
        margin-bottom: 10px;
    }

    .footer-social a {
        margin: 0 15px;
        display: inline-block;
        transition: transform 0.3s ease, filter 0.3s ease;
    }

    .footer-social img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        filter: grayscale(80%);
    }

    .footer-social a:hover img {
        transform: scale(1.2);
        filter: grayscale(0%);
    }

    .footer-bottom {
        margin-top: 5px;
        font-size: 14px;
    }

    .footer-bottom p {
        color: #bbb;
    }

    .footer-bottom p:hover {
        color: white;
    }
</style>

<footer>
    <div class="footer-container">
        <div class="footer-social">
            <a href="https://facebook.com" target="_blank"><img src="assets/fb.png" alt="Facebook"></a>
            <a href="https://x.com" target="_blank"><img src="assets/x.png" alt="Twitter"></a>
            <a href="https://instagram.com" target="_blank"><img src="assets/insta.png" alt="Instagram"></a>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 My Practical Exam Web Application. All rights reserved.</p>
        </div>
    </div>
</footer>
