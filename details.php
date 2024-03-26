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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $categoryName = $_POST["categoryName"];
    $detail1 = $_POST["detail1"];
    $detail2 = $_POST["detail2"];
    $detail3 = $_POST["detail3"];
    $detail4 = $_POST["detail4"];

    // Add more detail variables as needed

    // Prepare SQL statement
    $sql = "INSERT INTO details (category_name, detail1, detail2, detail3, detail4) VALUES ('$categoryName', '$detail1', '$detail2', '$detail3', '$detail4')";
    
    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        echo "New details added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
