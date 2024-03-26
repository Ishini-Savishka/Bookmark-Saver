<?php
session_start();
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

$deletion_message = ""; // Initialize deletion message variable

// Check if delete_detail parameter is set and handle delete action
if(isset($_POST['delete_detail'])) {
    $detail_name = $_POST['delete_detail'];

    // Prepare and bind the delete statement
    $stmt = $conn->prepare("DELETE FROM details WHERE detail_name = ?");
    $stmt->bind_param("s", $detail_name);

    // Execute the delete statement
    if ($stmt->execute()) {
        // Check if any rows were affected by the deletion
        if ($stmt->affected_rows > 0) {
            // Set deletion message
            $deletion_message = "Record deleted successfully";
        }
    }

    // Close the prepared statement
    $stmt->close();
}

// Fetch data associated with the logged-in user from the database
$user_id = $_SESSION["id"]; // Assuming $_SESSION["id"] contains the ID of the logged-in user

$sql = "SELECT * FROM details WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: rgb(4, 112, 189);
            background: linear-gradient(90deg, rgba(4, 112, 189, 1) 44%, rgba(0, 212, 255, 1) 100%);
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            padding: 20px;
            box-sizing: border-box; /* Include padding and border in the element's total width and height */
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff; /* Add background color to the table */
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        table img {
        max-width: 100px; 
        height: auto;
        display: block; 
        margin: 0 auto; 
    }
        .btn-delete,
        .btn-cancel,
        .btn-update {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            color: #fff;
            transition: background-color 0.3s;
        }

        .btn-delete {
            background-color: #ff5555;
        }

        .btn-update {
            background-color: #0470bd;
        }

        .btn-cancel {
            background-color: #555;
            margin-left: 5px;
        }

        .btn-delete:hover,
        .btn-update:hover,
        .btn-cancel:hover {
            background-color: #333;
        }

        .no-data {
            text-align: center;
            color: #555;
        }

        .action-buttons {
            display: flex;
            align-items: center;
        }

        .action-buttons form,
        .action-buttons button {
            margin-right: 5px;
        }

        /* Styles for the delete message */
        .delete-message {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        /* Media Queries */
        @media screen and (max-width: 768px) {
            .container {
                padding: 10px;
            }
            table th,
            table td {
                padding: 6px;
            }
            .btn-delete,
            .btn-cancel,
            .btn-update {
                padding: 6px 10px;
                font-size: 14px;
            }
        }
        </style>
</head>
<body>
    <div class="container">
        <h2>Details</h2>

        <!-- Display deletion message if deletion occurred -->
        <?php if (!empty($deletion_message)): ?>
            <div class="delete-message" id="deleteMessage"><?php echo $deletion_message; ?></div>
        <?php endif; ?>

        <!-- Display the table only if there is data available -->
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Detail Name</th>
                        <th>Detail Description</th>
                        <th>Detail URL</th>
                        <th>Detail Image</th>
                        <th>Category Name</th>
                        <th>Category Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["detail_name"]; ?></td>
                        <td><?php echo $row["detail_description"]; ?></td>
                        <td><a href="<?php echo $row["detail_url"]; ?>" target="_blank"><?php echo $row["detail_url"]; ?></a></td>
                        <td><img src="uploads/<?php echo $row["detail_image"]; ?>" alt="<?php echo $row["detail_name"]; ?>"></td>
                        <td><?php echo $row["category_name"]; ?></td>
                        <td><?php echo $row["category_type"]; ?></td>
                        <td class="action-buttons">
                            <form action="update.php" method="get">
                                <input type="hidden" name="detail_name" value="<?php echo $row["detail_name"]; ?>">
                                <button class="btn-update" type="submit" name="update">Update</button>
                            </form>
                            <form method="post">
                                <input type="hidden" name="delete_detail" value="<?php echo $row["detail_name"]; ?>">
                                <button class="btn-delete" type="submit">Delete</button>
                            </form>
                            <button class="btn-cancel" onclick="window.location.href = 'home.php';">Cancel</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No data available</p>
        <?php endif; ?>
    </div>
</body>
</html> 