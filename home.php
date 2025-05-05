<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - PHP User Management System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        header {
            background: #007bff;
            color: white;
            padding: 1rem 0;
            text-align: center;
            font-size: 24px;
        }
        .hero-section {
            background: url('https://via.placeholder.com/1200x400') no-repeat center center/cover;
            height: 60vh;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .hero-section h1 {
            font-size: 48px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }
        .main-content {
            padding: 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .feature-card {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 300px;
            text-align: center;
            transition: transform 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .feature-card h3 {
            color: #007bff;
        }
        .feature-card p {
            color: #666;
        }
        footer {
            background: #343a40;
            color: white;
            padding: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>

<?php include('nav.php'); ?>

<section class="hero-section">
    <div>
        <h1>Manage Users Seamlessly</h1>
        <p style= color:black>Your one-stop solution for secure user management.</p>
    </div>
</section>

<main class="main-content">
    <div class="feature-card">
        <h3>Secure Authentication</h3>
        <p>Signup and Login with advanced encryption for your safety.</p>
    </div>
    <div class="feature-card">
        <h3>Profile Management</h3>
        <p>Easily update your personal information and profile picture.</p>
    </div>
    <div class="feature-card">
        <h3>SQL Database Integration</h3>
        <p>Effortlessly store and retrieve user data with a reliable backend.</p>
    </div>
    <div class="feature-card">
        <h3>Responsive Design</h3>
        <p>Optimized for all devices - mobile, tablet, and desktop.</p>
    </div>
</main>

<footer>
    &copy; 2025 PHP User Management System. All rights reserved.
</footer>

</body>
</html>
