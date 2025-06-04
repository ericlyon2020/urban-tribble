<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['student_name'])) {
    $student_name = htmlspecialchars($_GET['student_name']);
    $message = "Thank you, $student_name! Your application has been successfully submitted.";
} else {
    $message = "Oops! Something went wrong. Please try again.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Application Success - PEN PALS ACADEMY</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f7f7f7;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .success-container {
      text-align: center;
      background-color: #ffffff;
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 600px;
    }
    .success-container p {
      font-size: 1.2rem;
      color: #333333;
      margin-bottom: 30px;
    }
    @media (min-width: 600px) {
      .success-container h1 {
        font-size: 28px;
      }
    }
    .success-icon {
      font-size: 4rem;
      color: rgb(36, 8, 101);
      margin-bottom: 20px;
    }
    .btn-home {
      background-color: rgb(20, 9, 72);
      color: #ffffff;
      font-size: 1rem;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
    }
    .btn-home:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>

  <div class="success-container">
    <i class="fas fa-check-circle success-icon"></i>
    <h1>Application Submitted!</h1>
    <p><?php echo $message; ?></p>
    <a href="index.php" class="btn-home">Back to Home</a>
  </div>

</body>
</html>
