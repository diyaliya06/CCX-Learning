<?php
require_once 'connect.php';
session_start();

// Database Configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ccx_db";

// Create Connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Registration
if (isset($_POST['register'])) {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $fullName, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href='/CCX/';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='/CCX/';</script>";
    }
    $stmt->close();
}

// Handle Login
// Handle Login
// Handle Login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL to prevent SQL injection (highly recommended)
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // "s" indicates a string parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['email'] = $row['email'];

            echo "<script>alert('Login successful!'); window.location.href='/CCX/';</script>";
        } else {
            echo "<script>alert('Invalid password.'); window.location.href='/CCX/';</script>";
        }
    } else {
        echo "<script>alert('No user found with this email.'); window.location.href='/CCX/';</script>";
    }

    $stmt->close(); // Close the prepared statement
}


// Handle Logout
if (isset($_GET['logout'])) {
    session_destroy();
    echo "<script>alert('Logged out successfully!'); window.location.href='/CCX/';</script>";
}

$conn->close();
?>
