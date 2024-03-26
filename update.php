<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: rgb(238,174,202);
background: radial-gradient(circle, rgba(238,174,202,1) 0%, rgba(216,177,209,1) 47%, rgba(202,179,214,1) 75%, rgba(148,187,233,1) 100%);            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        input[type="file"] {
            margin-top: 5px;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
        .btn-cancel{
background-color: #0470bd;
color:white;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button-container button {
            padding: 10px 20px;
            margin: 0 5px;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .form-group label {
            min-width: 120px; /* Adjust as needed */
            margin-right: 10px;
        }

        .form-group input[type="text"],
        .form-group textarea,
        .form-group input[type="file"] {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Update Details</h2>
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

        // Check if detail_name is provided via GET
        if(isset($_GET['detail_name'])) {
            // Retrieve detail_name from GET
            $detail_name = $_GET['detail_name'];

            // Fetch existing data from the database based on detail_name
            $sql = "SELECT * FROM details WHERE detail_name = '$detail_name'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Data found, populate the form fields
                $row = $result->fetch_assoc();
                $detail_name = $row['detail_name'] ?? '';
                $detail_description = $row['detail_description'] ?? '';
                $detail_url = $row['detail_url'] ?? '';
                $detail_image = $row['detail_image'] ?? '';
                
                // Set default values for category variables
                $category_name = isset($row['category_name']) ? $row['category_name'] : '';
                $category_type = isset($row['category_type']) ? $row['category_type'] : '';
                ?>
        <form action="process_update.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="detail_name">Name:</label>
                <input type="hidden" name="detail_name" value="<?php echo $detail_name; ?>">
                <span><?php echo $detail_name; ?></span> <!-- Display the current detail name -->
            </div>


            <div class="form-group">
                <label for="updated_detail_name">New Name:</label>
                <input type="text" id="updated_detail_name" name="updated_detail_name" value="<?php echo $detail_name; ?>">
            </div>

            <div class="form-group">
                <label for="detail_description">Detail Description:</label>
                <textarea id="detail_description" name="detail_description"><?php echo $detail_description; ?></textarea>
            </div>
            <div class="form-group">
                <label for="detail_url">Detail URL:</label>
                <input type="text" id="detail_url" name="detail_url" value="<?php echo $detail_url; ?>">
            </div>
            <div class="form-group">
                <label for="category_name">Category Name:</label>
                <input type="text" id="category_name" name="category_name" value="<?php echo $category_name; ?>">
            </div>
            <div class="form-group">
                <label for="category_type">Category Type:</label>
                <input type="text" id="category_type" name="category_type" value="<?php echo $category_type; ?>">
            </div>
            <div class="form-group">
                <label for="detail_image">New Image:</label>
                <input type="file" id="detail_image" name="new_image">
            </div>
            <div class="button-container">
                <input type="submit" value="Update">
                <button class='btn-cancel' onclick='window.location.href = "home.php";'>Cancel</button>
            </div>
        </form>

        <?php
            } else {
                echo "No data found";
            }
        } else {
            echo "No detail Name provided";
        }

        // Close connection
        $conn->close();
        ?>
    </div>
</body>
</html>
