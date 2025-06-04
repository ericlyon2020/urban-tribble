<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "Abigail@2020";
$dbname = "penpalsdb";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // Store in database
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();
    
    // Send email
    $to = 'penpalsacademy@gmail.com';
    $subject = 'New Contact Form Message';
    $email_message = "Name: $name\n";
    $email_message .= "Email: $email\n\n";
    $email_message .= "Message:\n$message";
    
    // Sanitize email headers to prevent injection
    $headers = 'From: ' . filter_var($email, FILTER_SANITIZE_EMAIL);
    $headers .= "\r\n" . 'Reply-To: ' . filter_var($email, FILTER_SANITIZE_EMAIL);
    $headers .= "\r\n" . 'X-Mailer: PHP/' . phpversion();
    
    mail($to, $subject, $email_message, $headers);
    
    // Redirect to success page
    header("Location: success.php?name=" . urlencode($name) . "&email=" . urlencode($email));
    exit(); // Ensure no further code is executed after redirection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - Penpals Academy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Your Contact Form -->
<form action="contact.php" method="POST">
    <label for="name">Full Name:</label>
    <input type="text" id="name" name="name" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    
    <label for="message">Message:</label>
    <textarea id="message" name="message" required></textarea>
    
    <button type="submit">Submit</button>
</form>

</body>
</html>
