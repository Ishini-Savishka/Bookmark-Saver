<?php
session_start();

if (!isset($_SESSION["id"])) {
    echo "Error: User not logged in.";
    exit();
}

if (isset($_POST['detailId']) && isset($_POST['action'])) {
    $detailId = $_POST['detailId'];
    $action = $_POST['action'];

    // Database configuration
    $servername = "localhost:3308";
    $username = "root";
    $password = "ish@123";
    $database = "bookmark";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        echo "Error: Connection failed: " . $conn->connect_error;
        exit();
    }

    if ($action === 'toggle') {
        // Check if the item already exists in favorites
        $checkSql = "SELECT COUNT(*) AS count FROM favorite_items WHERE id = ? AND detail_id = ?";
        $checkStmt = $conn->prepare($checkSql);
        if (!$checkStmt) {
            echo "Error: Prepare failed: " . $conn->error;
            $conn->close();
            exit();
        }

        // Bind parameters and execute SQL statement
        $checkStmt->bind_param("ii", $_SESSION["id"], $detailId);
        $checkStmt->execute();

        // Get the result
        $result = $checkStmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];

        // Close the statement
        $checkStmt->close();

        if ($count > 0) {
            // Item already exists in favorites, so remove it
            $deleteSql = "DELETE FROM favorite_items WHERE id = ? AND detail_id = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            if (!$deleteStmt) {
                echo "Error: Prepare failed: " . $conn->error;
                $conn->close();
                exit();
            }

            // Bind parameters and execute SQL statement
            $deleteStmt->bind_param("ii", $_SESSION["id"], $detailId);
            if ($deleteStmt->execute()) {
                // Item successfully removed from favorites
                echo "removed";
            } else {
                // Error occurred while removing item from favorites
                echo "Error: Unable to remove item from favorites. " . $conn->error;
            }

            // Close prepared statement
            $deleteStmt->close();
        } else {
            // Item doesn't exist in favorites, so add it
            $insertSql = "INSERT INTO favorite_items (id, detail_id) VALUES (?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            if (!$insertStmt) {
                echo "Error: Prepare failed: " . $conn->error;
                $conn->close();
                exit();
            }

            // Bind parameters and execute SQL statement
            $insertStmt->bind_param("ii", $_SESSION["id"], $detailId);
            if ($insertStmt->execute()) {
                // Item successfully added to favorites
                echo "added";
            } else {
                // Error occurred while adding item to favorites
                echo "Error: Unable to add item to favorites. " . $conn->error;
            }

            // Close prepared statement
            $insertStmt->close();
        }
    } else {
        // Invalid action
        echo "Error: Invalid action.";
    }

    // Close database connection
    $conn->close();
} else {
    // Required parameters not provided in the POST request
    echo "Error: Insufficient parameters.";
}
?>
