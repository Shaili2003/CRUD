# Web Application Project

## Overview
This project is a simple web application built with HTML, CSS, JavaScript, and PHP, using MySQL as the database. The application includes features such as user registration, login, profile management, and database integration.

## Features
- **User Registration:** Allows users to register an account.
- **Login/Logout:** Secure login and logout functionality.
- **Profile Management:** Users can view and update their profile information.
- **Database Integration:** All data is stored and managed using a MySQL database.

## Project Structure
- **db.php:** Database connection file.
- **index.php:** Login page.
- **home.php:** Homepage after successful login.
- **profile.php:** Profile management page.
- **register.php:** User registration page.
- **update.php:** Profile update script.
- **delete.php:** Account deletion script.
- **nav.php:** Navigation bar.
- **footer.php:** Footer for all pages.
- **webapplication.sql:** SQL file to set up the database.
- **assets:** Folder containing image assets.
- **uploads:** Folder for storing uploaded profile images.

## Prerequisites
- XAMPP or any other local web server environment.
- Web browser.

## Setup Instructions
1. Install XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/).
2. Clone or download this repository.
3. Copy the project folder into the `htdocs` directory inside the XAMPP installation.
4. Start the Apache and MySQL modules in the XAMPP control panel.
5. Open phpMyAdmin by visiting [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/).
6. Create a new database named `webapplication`.
7. Import the `webapplication.sql` file to set up the database structure.
8. Open the project in your browser at [http://localhost/WebApplication/](http://localhost/WebApplication/).

## Usage
1. Register a new user account.
2. Log in using the registered credentials.
3. Navigate to the profile page to update your information.
4. Log out when done.

