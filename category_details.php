<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: rgb(4, 112, 189);
            background: linear-gradient(90deg, rgba(4, 112, 189, 1) 44%, rgba(0, 212, 255, 1) 100%);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
            max-height: 100px;
            display: block;
            margin: 0 auto;
        }

        .btn-delete,
        .btn-cancel {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            color: #fff;
            transition: background-color 0.3s;
        }

        .btn-delete {
            background-color: #ff5555;
        }

        .btn-delete:hover {
            background-color: #ff0000;
        }

        .btn-cancel {
            background-color: #555;
            margin-left: 5px;
        }

        .btn-cancel:hover {
            background-color: #333;
        }

        .no-data {
            text-align: center;
            color: #555;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Category List</h2>

        <?php
        // Check for success message
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo "<p style='color: green; text-align: center;'>New category added successfully!</p>";
        }
        ?>

        <table>
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Category Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
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

                // Retrieve data from the database
                $sql = "SELECT category_id, category_name, category_image FROM category";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["category_id"] . "</td>";
                        echo "<td>" . $row["category_name"] . "</td>";
                        echo "<td><img src='" . $row["category_image"] . "' alt='Category Image'></td>";
                        echo "<td>
                                <button class='btn-delete' onclick='deleteCategory(" . $row["category_id"] . ")'>Delete</button>
                                <button class='btn-cancel' onclick='cancelAction()'>Cancel</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='no-data'>No categories found</td></tr>";
                }

                // Close connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function deleteCategory(categoryId) {
            if (confirm("Are you sure you want to delete this category?")) {
                // Make an AJAX request to delete the category
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            // Reload the page to reflect changes
                            location.reload();
                        } else {
                            alert("Error deleting category.");
                        }
                    }
                };
                xhr.open("POST", "delete_category.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("category_id=" + categoryId);
            }
        }

        function cancelAction() {
            // Redirect to index.php page
            window.location.href = "category.html";
        }
    </script>
</body>

</html>
