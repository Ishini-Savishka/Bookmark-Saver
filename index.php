<?php
// Start session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION["username"])) {
    // Continue only if the current page is not the login page
    if (basename($_SERVER["PHP_SELF"]) != "index.php") {
        // Redirect to the login page
        header("Location: index.php");
        exit(); // Stop further execution
    }
}

$error = ""; // Initialize error variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Retrieve username and password from the form
    $username = $_POST["userName"];
    $password = $_POST["password"];

    // Validate user credentials
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Valid credentials, fetch user details from the database
        $user_data = $result->fetch_assoc();
        
        // Set session variables
        $_SESSION["id"] = $user_data['id']; // Assuming 'id' is the column name for user ID in your database
        $_SESSION["username"] = $user_data['username']; // Assuming 'username' is the column name for username in your database
        
        // Redirect to the home page
        header("Location: home.php");
        exit();
    } else {
        $error = "Invalid username or password!"; // Set error message
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="dist/css/login.css">
  <link rel="manifest" href="manifest.json">
  <meta name="theme-color" content="#ffffff">
</head>

<style>
    .error-message {
      color: red;
      font-weight: bold;
    }
</style>

<body>
<div class="wrapper">
    <div class="logo">
        <img src="dist/img/logo.svg" alt="">
    </div>
    <div class="text-center mt-4 name">
        Bookmark Saver
    </div>
    <form class="p-3 mt-3" method="post" action="index.php" onsubmit="return validateForm()">
        <div class="form-field d-flex align-items-center">
            <span class="far fa-user"></span>
            <input type="text" name="userName" id="userName" placeholder="Username">
        </div>
        <div class="form-field d-flex align-items-center">
            <span class="fas fa-key"></span>
            <input type="password" name="password" id="pwd" placeholder="Password">
        </div>
        <button type="submit" class="btn mt-3">Login</button>
        <p id="errorMessage" class="error-message mt-3" style="display: none;">Please enter credentials !</p>
    </form>
    <div class="text-center fs-6">
        <p>Don't have an account?</p><a href="register.php">Sign up</a>
    </div>
    <div class="text-center fs-6 mt-3">
        <form action="home.php">
            <button type="submit" class="guestbtn">Continue as Guest</button>
        </form>
    </div>
</div>

<script>
    function validateForm() {
        var username = document.getElementById("userName").value;
        var password = document.getElementById("pwd").value;
        if (username.trim() === "" || password.trim() === "") {
            document.getElementById("errorMessage").style.display = "block";
            return false;
        }
        return true;
    }
</script>

</body>
</html>
