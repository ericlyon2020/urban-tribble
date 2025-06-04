<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "Abigail@2020";
$dbname = "penpalsdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and assign POST data
    $student_name = mysqli_real_escape_string($conn, $_POST['student_name']);
    $guardian_name = mysqli_real_escape_string($conn, $_POST['guardian_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Prepare and bind the SQL query
    $stmt = $conn->prepare("INSERT INTO applications (student_name, guardian_name, email, phone, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $student_name, $guardian_name, $email, $phone, $message);

    // Execute the query and check for errors
    if ($stmt->execute()) {
        // Redirect to success page
        header("Location: success.php?student_name=" . urlencode($student_name));
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
