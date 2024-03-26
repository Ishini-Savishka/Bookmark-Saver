<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION["id"])) {
    // Redirect to login page or show an error message
    header("Location: index.php");
    exit;
}

// Database connection code
$servername = "localhost:3308";
$username = "root";
$password = "ish@123";
$dbname = "bookmark";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch existing user details
$userId = $_SESSION["id"];
$sql = "SELECT username, password, profile_image FROM users WHERE id = '$userId'";
$result = $conn->query($sql);

// Check if user details exist
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $firstName = $row["username"]; // Update to match the actual column name
    $currentPassword = $row["password"]; // Retrieve current password
    $profileImage = $row["profile_image"]; // Retrieve current profile image
} else {
    // User details not found
    echo "Error: User details not found.";
    exit;
}

// Define variables for success and error messages
$passwordSuccess = $passwordError = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["saveProfile"])) {
    // Check if a new profile picture is uploaded
    if (!empty($_FILES["profilePic"]["name"])) {
        // Handle file upload
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["profilePic"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if file already exists, overwrite it
        if (file_exists($targetFile)) {
            unlink($targetFile); // Delete the existing file
        }

        // Check file size
        if ($_FILES["profilePic"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowedFormats = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowedFormats)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $targetFile)) {
                // Update profile image path in the database
                $profileImage = $targetFile;
                $updateSql = "UPDATE users SET profile_image = '$profileImage' WHERE id = '$userId'";
                if ($conn->query($updateSql) !== TRUE) {
                    echo "Error updating profile image: " . $conn->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    
    // Update first name if changed
    // Fetch total count of bookmarks for the logged-in user
    $sql = "SELECT COUNT(*) AS total_bookmarks FROM details WHERE id = '$userId'";
    $result = $conn->query($sql);
    
    if ($result === false) {
        echo "Error: " . $conn->error;
        // You might want to handle this error appropriately, such as logging it or displaying a user-friendly message
    } else {
        $totalBookmarks = 0;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalBookmarks = $row["total_bookmarks"];
        }
    }
    
    // Define the maximum number of bookmarks or retrieve it from your database or configuration file
    $maximumBookmarks = 100; // Example value, replace it with your actual maximum number of bookmarks
    
    // Avoid division by zero error
    $progressWidth = $maximumBookmarks > 0 ? ($totalBookmarks / $maximumBookmarks) * 100 : 0;
    

    // Handle password change
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if (!empty($newPassword) && !empty($confirmPassword)) {
        if ($newPassword === $confirmPassword) {
            // Update password
            $updatePasswordSql = "UPDATE users SET password = '$newPassword' WHERE id = '$userId'";
            if ($conn->query($updatePasswordSql) !== TRUE) {
                echo "Error updating password: " . $conn->error;
            } else {
                $currentPassword = $newPassword; // Update current password variable
                $passwordSuccess = "Details updated successfully!";
            }
        } else {
            $passwordError = "New password and confirm password do not match.";
        }
    }
    
    // Set session variable to indicate success message shown
    $_SESSION['success_message_shown'] = true;
}

// Fetch total count of bookmarks for the logged-in user
$sql = "SELECT COUNT(*) AS total_bookmarks FROM details WHERE id = '$userId'";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $conn->error;
    // You might want to handle this error appropriately, such as logging it or displaying a user-friendly message
} else {
    $totalBookmarks = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalBookmarks = $row["total_bookmarks"];
    }
}


// Define the maximum number of bookmarks or retrieve it from your database or configuration file
$maximumBookmarks = 100; // Example value, replace it with your actual maximum number of bookmarks

// Avoid division by zero error
$progressWidth = $maximumBookmarks > 0 ? ($totalBookmarks / $maximumBookmarks) * 100 : 0;

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bookmark</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="dist/css/style.css">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#ffffff">
</head>
<style>
    body {
    background: rgb(99, 39, 120)
}

.form-control:focus {
    box-shadow: none;
    border-color: #BA68C8
}

.profile-button {
    background: rgb(99, 39, 120);
    box-shadow: none;
    border: none
}

.profile-button:hover {
    background: #682773
}

.profile-button:focus {
    background: #682773;
    box-shadow: none
}

.profile-button:active {
    background: #682773;
    box-shadow: none
}

.back:hover {
    color: #682773;
    cursor: pointer
}

.labels {
    font-size: 11px
}

.add-bookmark:hover {
    background: #BA68C8;
    color: #fff;
    cursor: pointer;
    border: solid 1px #BA68C8
}
.success-msg {
    color: green;
}
.custom-btn-width {
    width: 150px; /* Adjust the width as needed */
}

</style>  
<body>
<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <!-- Profile Information -->
<!-- Profile Information -->
<!-- Profile Information -->
<div class="col-md-3 border-right">
    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
        <!-- Updated Profile Picture -->
        <img class="rounded-circle mt-5" width="150px" src="<?php echo isset($profileImage) ? $profileImage : 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg'; ?>">
        <!-- Profile Name and Email -->
        <span class="font-weight-bold"><?php echo $firstName; ?></span> <!-- Update here to display the updated first name -->
        <!-- Edit Profile Button -->
        <div class="btn btn-info mt-3"><i class="fas fa-user-edit"></i> Edit Profile</div>
    </div>
</div>


<!-- Profile Settings -->
<div class="col-md-5 border-right">
    <div class="p-3 py-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
         <h4 class="text-right">Profile Settings</h4>
        </div>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
    <!-- Profile Picture Upload -->
    <div class="mb-3">
        <label for="profilePic" class="form-label">Profile Picture</label>
        <input class="form-control" type="file" id="profilePic" name="profilePic">
    </div>
    <!-- Name and Surname Fields -->
    <div class="row mt-2">
        <div class="col-md-12">
            <label class="labels">User Name</label>
            <input type="text" class="form-control" name="firstName" placeholder="First name" value="<?php echo $firstName; ?>">
        </div>
    </div>
    <!-- Password Fields -->
    <div class="row mt-2">
    <div class="col-md-12">
        <label class="labels">Current Password</label>
        <input type="password" class="form-control" name="currentPassword" placeholder="Current password" value="<?php echo $currentPassword; ?>" disabled>
    </div>
</div>
    <div class="row mt-2">
        <div class="col-md-12">
            <label class="labels">New Password</label>
            <input type="password" class="form-control" name="newPassword" placeholder="New password">
        </div>
    </div>
    <?php if (isset($passwordError)) { ?>
    <div class="row mt-2">
        <div class="col-md-12 text-danger"><?php echo $passwordError; ?></div>
    </div>
<?php } ?>
<div class="row mt-2">
    <div class="col-md-12">
        <label class="labels">Confirm Password</label>
        <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm password">
    </div>
</div>
<div class="mt-5 text-center">
    <div class="row">
        <div class="col-md-6 mb-2">
            <button class="btn btn-primary profile-button btn-block custom-btn-width" type="submit" name="saveProfile">Save Profile</button>
        </div>
        <div class="col-md-6 mb-2">
            <button class="btn btn-danger btn-block custom-btn-width" type="button" onclick="window.location.href='home.php'">Cancel</button>
        </div>
    </div>
</div>


</form>
<?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["saveProfile"]) && !empty($passwordSuccess)): ?>
        <div class="row mt-3">
            <div class="col-md-12 text-center success-msg"><?php echo $passwordSuccess; ?></div>
        </div>
    <?php endif; ?>

            </div>
        </div>
        <div class="col-md-4">
    <div class="p-3 py-5">
        <div class="d-flex justify-content-between align-items-center bookmark">
            <span class="font-weight-bold">My Bookmarks</span>
            <span class="border px-3 p-1 add-bookmark" onclick="window.location.href='data.php'">&nbsp;Manage Bookmark</span>
        </div>
    </div>
    <div class="col-12">
    <div class="info-box bg-info">
        <span class="info-box-icon"><i class="far fa-bookmark"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Total Bookmarks</span>
            <p class="card-text"><?php echo $totalBookmarks; ?></p>

            <?php
                // Calculate the percentage of completion
                $percentage = ($totalBookmarks / $maximumBookmarks) * 100; 
            ?>

            <div class="progress">
                <div class="progress-bar" style="width: <?php echo $percentage; ?>%"></div>
            </div>
        </div>
        </div>
    </div>
</div>

</div>

<script>
        setTimeout(function() {
            var successMessage = document.querySelector('.success-msg');
            if (successMessage) {
                successMessage.parentNode.removeChild(successMessage);
            }
        }, 3000);
    </script>

    <!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/demo.js"></script>
</body>
</html>
