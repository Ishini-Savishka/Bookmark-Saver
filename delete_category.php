<?php
// Database configuration
$servername = "localhost:3308";
$username = "root";
$password = "ish@123";
$database = "bookmark";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if category_id is set and not empty
if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
    // Sanitize the input to prevent SQL injection
    $category_id = $_POST['category_id'];

    // Prepare SQL statement to delete the category
    $sql = "DELETE FROM category WHERE category_id = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // If deletion is successful, return a success message
        echo "Category deleted successfully";
    } else {
        // If deletion fails, return an error message
        echo "Error deleting category: " . $conn->error;
    }

    // Close statement
    $stmt->close();
} else {
    // If category_id is not set or empty, return an error message
    echo "Invalid category ID";
}

// Close connection
$conn->close();
?>
