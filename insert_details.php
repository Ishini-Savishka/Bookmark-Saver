<?php
// Database configuration
$servername = "localhost:3308";
$username = "root";
$password = "ish@123";
$database = "bookmark";

// Start session
session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $detail_name = $_POST['detail_name'];
    $detail_description = $_POST['detail_description'];
    $detail_url = $_POST['detail_url'];
    $category_name = $_POST['category_name'];
    $category_type = $_POST['category_type'];

    // Retrieve user ID from session
    $user_id = $_SESSION['id'];

    // Handle file upload (if applicable)
    if(isset($_FILES['detail_image']) && $_FILES['detail_image']['error'] === UPLOAD_ERR_OK) {
        $detail_image = $_FILES['detail_image']['name'];
        $target_dir = "uploads/"; // Specify the directory where you want to save the image
        $target_file = $target_dir . basename($_FILES["detail_image"]["name"]);
        move_uploaded_file($_FILES["detail_image"]["tmp_name"], $target_file);
    } else {
        // Default image or handle error condition
        $detail_image = ''; 
    }

    // Insert data into database using prepared statement to prevent SQL injection
    $sql = "INSERT INTO details (detail_name, detail_description, detail_url, detail_image, category_name, category_type, id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $detail_name, $detail_description, $detail_url, $detail_image, $category_name, $category_type, $user_id);

    if ($stmt->execute()) {
        header("Location: data.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}

// Retrieve data from the database
$sql = "SELECT * FROM details";
$result = $conn->query($sql);
?>
