<?php
require '../db/conn.php';  // Include your database connection file
include "../functions/helpers.php";
if (!check_user_authentication()) {
     redirect("../");
 }
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$user_id = $_COOKIE['user_id'];  // Get the logged-in user's ID
$title = $_POST['title'];
$content = $_POST['content'];

// Handle image upload if present
$image_path = null;  // Default value if no image is uploaded


if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
     // Validate and process the uploaded image
     $image_dir = '../public/articles-images/';  // Directory to store images

     // Generate a unique name for the image
     $image_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);  // Get the file extension
     $image_name = uniqid('article_', true) . '.' . $image_extension;  // Generate unique name

     $image_path = $image_dir . $image_name;

     // Move uploaded file to the destination folder
     if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
         echo "Error uploading image.";
         exit();
     }
 }

// Prepare and execute the SQL query to insert the article into the database
$stmt = $conn->prepare("INSERT INTO articles (user_id, title, content, image_path) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $user_id, $title, $content, $image_path);

if ($stmt->execute()) {
    echo "Article submitted successfully.";
} else {
    echo "Error submitting article: " . $stmt->error;
}
$stmt->close();
 }
 
?>

















<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Article</title>
</head>
<body>

<h2>Submit an Article</h2>

<form method="POST" enctype="multipart/form-data">
    <div>
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>
    </div>

    <div>
        <label for="content">Content:</label>
        <textarea name="content" id="content" rows="5" required></textarea>
    </div>

    <div>
        <label for="image">Image (optional):</label>
        <input type="file" name="image" id="image">
    </div>

    <button type="submit">Submit Article</button>
</form>

</body>
</html>
