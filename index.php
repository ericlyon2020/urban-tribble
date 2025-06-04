<?php
header("Content-Security-Policy: script-src 'self' 'unsafe-inline';");

$servername = "localhost"; // Change to your database server
$username = "root"; // Replace with your database username
$password = "Abigail@2020"; // Replace with your database password
$dbname = "penpalsdb"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PEN PALS ACADEMY</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="css/gallery-styles.css"> <!-- Link to gallery-styles.css inside the 'css' folder -->
  <link rel="stylesheet" href="css/gallery.css"> <!-- Link to gallery.css inside the 'css' folder -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <!-- Header -->
  <header class="header">
     <div class="logo-container">
    <img src="logo.jpg" alt="Penpals Academy Logo" class="school-logo">
      <h1>PEN PALS ACADEMY</h1>
    </div>
    <nav class="navbar">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="gallery.php">Gallery</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </nav>
  </header>

<!-- Hero Section -->
<section class="hero">
  <img src="school.jpg" alt="school photo" class="hero-image">
  <div class="hero-overlay">
    <div class="hero-content">
      <h2>MODELLING EXCELLENCE</h2>
      <a href="#apply" class="btn-apply">Apply Now</a>
    </div>
  </div>
</section>

<!-- About Section -->
<section id="about" class="about">
  <div class="container">
    <h2>Welcome to PEN PALS ACADEMY</h2>
    <p>Located in Githurai 44, behind Naivas Supermarket off Kamiti road, we are dedicated to nurturing academic excellence, creativity, and strong values in all learners.</p>
  </div>
</section>

<!-- Why Choose Us Section -->
<section id="why-choose-us" class="why-choose-us">
  <div class="container">
    <h2>Why Choose PEN PALS ACADEMY</h2>
    <div class="reasons-grid">
      <div class="reason">
        <i class="fas fa-chalkboard-teacher icon"></i>
        <h3>Experienced Teachers</h3>
        <p>Our staff are passionate, professional, and committed to nurturing academic excellence.</p>
      </div>
      <div class="reason">
        <i class="fas fa-lightbulb icon"></i>
        <h3>Holistic Learning</h3>
        <p>We combine academics, talent development, and character building for balanced growth.</p>
      </div>
      <div class="reason">
        <i class="fas fa-shield-alt icon"></i>
        <h3>Safe & Supportive Environment</h3>
        <p>Located in a serene, accessible area with close student guidance and mentoring.</p>
      </div>
      <div class="reason">
        <i class="fas fa-coins icon"></i>
        <h3>Affordable Quality Education</h3>
        <p>We offer competitive, value-packed education options for all learners.</p>
      </div>
    </div>
  </div>
</section>

<!-- Gallery Section -->
<section class="gallery">
  <div class="container">
    <h2>Gallery</h2>
    <div class="gallery-grid">
      <?php
      // Fetch latest 3 images from the database
      $sql = "SELECT * FROM gallery ORDER BY id DESC LIMIT 3"; // Get latest 3 images
      $result = $conn->query($sql);

      if ($result->num_rows > 0):
        while($row = $result->fetch_assoc()):
      ?>
        <div class="gallery-item">
          <?php $filename = $row['filename'] ?? ''; ?>
          <img src="images/<?php echo htmlspecialchars($filename); ?>" alt="Preview Image">
        </div>
      <?php endwhile; else: ?>
        <p>No photos available yet.</p>
      <?php endif; ?>
    </div>
    <div class="view-more">
      <a href="gallery.php">View More &rarr;</a>
    </div>
  </div>
</section>

<!-- CTA / Application Section -->
<section id="apply" class="apply">
  <div class="container">
    <h3>Join PENPALS ACADEMY Today!</h3>
    <p>Ready to model excellence? Get in touch with us or visit our school for a tour.</p>
    <a href="#contact" class="btn-apply">Contact Us</a>
  </div>
</section>

<!-- Application Form Section -->
<section id="application" class="application-form">
  <div class="container">
    <h2>Student Application Form</h2>
    <form action="process_form.php" method="POST">
      <input type="text" name="student_name" placeholder="Student's Full Name" required>
      <input type="text" name="guardian_name" placeholder="Parent/Guardian Name" required>
      <input type="email" name="email" placeholder="Parent Email" required>
      <input type="tel" name="phone" placeholder="Phone Number" required>
      <textarea name="message" placeholder="Any additional information..." rows="4"></textarea>
      <button type="submit">Submit Application</button>
    </form>
  </div>
</section>

<!-- Contact Section -->
<section id="contact" class="contact">
  <div class="container">
    <h2>Contact Us</h2>
    <p><strong>Location:</strong> Githurai 44, behind Naivas Supermarket off Kamiti road</p>
    <p><strong>Phone:</strong> 075824249740, 0768751632, 0103465812</p>
    <p><strong>Email:</strong> penpalsacademy@gmail.com</p>
  </div>
</section>

<script src="script.js"></script>

<!-- Footer Section -->
<footer class="footer">
  <div class="container">
    <p>&copy; 2025 PENPALS ACADEMY. All Rights Reserved.</p>
    <p>Contact Us: 075824249740 | 0768751632 | 0103465812</p>
    <p>Email: <a href="mailto:penpalsacademy@gmail.com">penpalsacademy@gmail.com</a></p>
  </div>
</footer>

</body>
</html>
