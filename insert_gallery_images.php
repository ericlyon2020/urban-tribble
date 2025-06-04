<?php
// 1. Connect to MySQL
$host = "localhost";
$user = "root";
$password = "Abigail@2020"; // Change if needed
$dbname = "penpalsdb";

$conn = new mysqli($host, $user, $password, $dbname);

// 2. Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. Categories with folder-based images
$baseDir = "images/";
$categories = [
    "ADVERTS", "ADVERT TEAM", "CLASSROOM", "CREATIVE ART", "FAMILY FUN DAY",
    "OUTDOOR GAMES", "GRADUATION", "HOLIDAY CAMP", "INDOOR GAMES", "LUNCH",
    "NEWSLETTER", "PARENTS", "SCHOOL PHOTOS", "SCHOOL COMMUNITY",
    "ENTERTAINMENT", "STUDENTS RECTREATION", "TEA TIME", "TEAM BUILDING", "TEACHERS"
];
$inserted_count = 0;
$skipped_count = 0;
$error_count = 0;<img src="images/<?php echo htmlspecialchars($filename); ?>" ...>
<img src="images/<?php echo htmlspecialchars($filename); ?>" ...>


echo "<h2>Scanning image folders and updating gallery database...</h2>";

// Prepare statement to check for existing images
if ($check_stmt = $conn->prepare("SELECT id FROM gallery WHERE filename = ? LIMIT 1")) {

    // Prepare statement for inserting new images
    if ($insert_stmt = $conn->prepare("INSERT INTO gallery (title, filename) VALUES (?, ?)")) {

        // 4. Scan and insert each image into the gallery table
        foreach ($categories as $category) {
            $folderPath = $baseDir . $category . "/";

            if (!is_dir($folderPath)) {
                echo "⛔ Folder not found: $folderPath<br>";
                $error_count++;
                continue;
            }

            $images = scandir($folderPath);
            foreach ($images as $image) {
                if ($image === '.' || $image === '..') continue;

                $fullPath = $folderPath . $image;
                if (is_file($fullPath)) {
                    $relativePath = $category . "/" . $image; // Save path like: TEACHERS/photo1.jpg

                    // Check if the image already exists in the database
                    $check_stmt->bind_param("s", $relativePath);
                    $check_stmt->execute();
                    $check_stmt->store_result();

                    if ($check_stmt->num_rows > 0) {
                        echo "⏭️ Image already exists, skipping: $relativePath<br>";
                        $skipped_count++;
                    } else {
                        // Image does not exist, insert it
                        $insert_stmt->bind_param("ss", $category, $relativePath);
                        if ($insert_stmt->execute()) {
                            echo "✅ Image inserted: $relativePath<br>";
                            $inserted_count++;
                        } else {
                            echo "❌ Error executing insert query for $relativePath: " . $insert_stmt->error . "<br>";
                            $error_count++;
                        }
                    }
                }
            }
        }

        $insert_stmt->close();
    } else {
        echo "❌ Error preparing insert statement: " . $conn->error . "<br>";
        $error_count++;
    }

    $check_stmt->close();
} else {
    echo "❌ Error preparing check statement: " . $conn->error . "<br>";
    $error_count++;
}


echo "<h2>Processing Complete</h2>";
echo "✅ Total images inserted: $inserted_count<br>";
echo "⏭️ Total images skipped (already exist): $skipped_count<br>";
echo "❌ Total errors encountered: $error_count<br>";

$conn->close();
?>
