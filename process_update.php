<?php
// Check if detail_name is provided via POST
if(isset($_POST['detail_name'])) {
    // Retrieve detail_name from POST
    $detail_name = $_POST['detail_name'];

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

    // Retrieve other form data
    $detail_description = $_POST['detail_description'];
    $detail_url = $_POST['detail_url'];
    $category_name = $_POST['category_name'];
    $category_type = $_POST['category_type'];

    // Check if detail_name has changed
    $new_detail_name = $_POST['updated_detail_name']; // Changed from 'detail_name'
    if ($new_detail_name != $detail_name) {
        // If detail_name has changed, update it in the database
        $sql_update_name = "UPDATE details SET detail_name='$new_detail_name' WHERE detail_name='$detail_name'";
        if ($conn->query($sql_update_name) !== TRUE) {
            echo "Error updating detail name: " . $conn->error;
            $conn->close();
            exit();
        }
        // Update $detail_name with the new value
        $detail_name = $new_detail_name;
    }

    // Prepare and execute update statement
    $sql = "UPDATE details SET detail_description='$detail_description', detail_url='$detail_url', category_name='$category_name', category_type='$category_type' WHERE detail_name='$detail_name'";

    if ($conn->query($sql) === TRUE) {
        // Close connection
        $conn->close();
        
        // Redirect back to the page where details are displayed
        header("Location: data.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "No detail name provided.";
}
?>
