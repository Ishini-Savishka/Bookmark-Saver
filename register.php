<?php


// Check if the form is submitted
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

    // Check if username already exists
    $sql_check = "SELECT * FROM users WHERE username='$username'";
    $result_check = $conn->query($sql_check);
    if ($result_check->num_rows > 0) {
        $error = "Username already exists";
    } else {
        // Insert new user into the database
        $sql_insert = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql_insert) === TRUE) {
            // Automatically log in the new user
            $_SESSION["username"] = $username;
            // Redirect to home page
            header("Location: index.php");
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Register</title>
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
<body>
  <div class="wrapper">
    <div class="logo">
      <img src="dist/img/logo.svg" alt="">
    </div>
    <div class="text-center mt-4 name">
      Bookmark Saver
    </div>
    <br>
    <form method="post" action="register.php">
      <?php if (!empty($error)) : ?>
        <p style="color: red;"><?php echo $error; ?></p> <!-- Display error message -->
      <?php endif; ?>
      <div class="form-field d-flex align-items-center">
        <span class="far fa-user"></span>
        <input type="text" name="userName" id="userName" placeholder="Username">
      </div>
      <div class="form-field d-flex align-items-center">
        <span class="fas fa-key"></span>
        <input type="password" name="password" id="pwd" placeholder="Password">
      </div>
      <button class="btn mt-3">Register</button>
    </form>
    <br>
    <div class="text-center fs-6">
      <p>Already have an account?</p> <a href="index.php">Login</a>
    </div>
  </div>
</body>
</html>
