<?php
$host = "localhost";
$user = "root";
$password = "Abigail@2020";
$dbname = "penpalsdb";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all images from the database, ordered by title and then id
$sql = "SELECT id, title, filename FROM gallery ORDER BY title ASC, id DESC";
$result = $conn->query($sql);

$gallery = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $gallery[$row['title']][] = $row['filename'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Added viewport for responsiveness -->
    <title>Penpals Academy Gallery</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Basic styles for gallery page - can be moved to a separate CSS file */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .gallery-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }
        .gallery-header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .gallery-header h1 {
            color: #003366;
            margin-bottom: 10px;
        }
        .gallery-header p {
            color: #555;
            font-size: 1.1em;
        }
        h2 {
            text-align: center;
            background: #004080;
            color: white;
            padding: 15px; /* Increased padding */
            margin-top: 30px; /* Space above category heading */
            margin-bottom: 20px; /* Space below category heading */
            border-radius: 5px;
        }
        .back-home {
            position: fixed;
            top: 20px;
            left: 20px;
            background: #f7c52b;
            color: #000;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            z-index: 1000;
            font-size: 1.5em; /* Increased icon size */
        }
        .back-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .category-section {
            padding: 20px;
            background-color: #fff; /* White background for sections */
            margin-bottom: 30px; /* Space between sections */
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .gallery-grid {
            display: grid; /* Use grid for better layout control */
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Responsive grid */
            gap: 20px; /* Space between grid items */
            justify-content: center;
        }
        .gallery-item {
            text-align: center;
            border: 1px solid #ddd; /* Subtle border */
            border-radius: 8px;
            overflow: hidden; /* Hide parts of the image outside the container */
            background-color: #f9f9f9; /* Light background */
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Add hover effect */
        }
         .gallery-item:hover {
            transform: translateY(-5px); /* Lift effect */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .gallery-item img {
            display: block; /* Remove extra space below image */
            width: 100%;
            height: 200px; /* Fixed height for gallery images */
            object-fit: cover; /* Crop image to fit */
            cursor: pointer; /* Indicate clickable */
            transition: transform 0.3s ease; /* Add hover effect */
        }
         .gallery-item img:hover {
            transform: scale(1.05); /* Zoom effect on hover */
        }
         /* Optional: Add a caption below the image if you have one in the database */
        /* .gallery-item p {
            padding: 10px;
            margin: 0;
            font-size: 0.9em;
            color: #555;
        } */

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); /* Adjust grid for smaller screens */
                gap: 15px;
            }
            .gallery-item img {
                height: 150px; /* Adjust image height for smaller screens */
            }
            h2 {
                font-size: 1.5em;
                padding: 10px;
            }
             .back-home {
                width: 40px;
                height: 40px;
                font-size: 1.2em;
            }
        }
    </style>
</head>
<body>
    <a href="index.php" class="back-home" title="Back to Home">
        <i class="fas fa-arrow-left"></i>
    </a>

<div class="gallery-container">
    <div class="gallery-header">
        <h1>Our Photo Gallery</h1>
        <p>Explore life at Penpals Academy through our collection of memories</p>
    </div>

    <?php if (!empty($gallery)): ?>
        <?php foreach ($gallery as $category => $filenames): ?>
            <div class="category-section">
                <h2><?php echo htmlspecialchars(str_replace('_', ' ', $category)); ?></h2>
                <div class="gallery-grid">
                    <?php foreach ($filenames as $filename): ?>
                        <div class="gallery-item">
                            <img src="<?php echo htmlspecialchars('images/' . $filename); ?>"
                                 alt="<?php echo htmlspecialchars(str_replace('_', ' ', $category)); ?>"
                                 loading="lazy"
                                 onclick="this.requestFullscreen();">
                            <?php
                                // Optional: If you had a caption column in your database, you could display it here
                                // echo '<p>' . htmlspecialchars($row['caption']) . '</p>';
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="category-section">
            <p style="text-align: center;">No photos available yet.</p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>
