<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit();
}

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

// Fetch favorite items for the logged-in user
if (isset($_SESSION["id"])) {
    $user_id = $_SESSION["id"]; // Assuming "id" is the column name in the "users" table
    
    // Prepare and bind the SELECT statement
    $sql = "SELECT details.* FROM favorite_items 
            INNER JOIN details ON favorite_items.detail_id = details.detail_id 
            WHERE favorite_items.id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("i", $user_id);

    // Execute the statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Close the statement
    $stmt->close();
} else {
    $result = false; // No user ID found in the session
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>My Favorites</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="dist/css/style.css">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#ffffff">
</head>
<style>
    .body{
        background-image:url('https://img.freepik.com/free-vector/abstract-colorful-shapes-background_361591-2848.jpg?t=st=1710924104~exp=1710927704~hmac=fdbfa99435860f8f6a62d97e7aa127a5a39fc2f46740a499fd9d09cf77e111f1&w=1380');
    }
        .card {
            width: 100%;
            max-width: 300px;
            margin-bottom: 20px;
            border-color: black;
            border-radius: 10px;
            border-width: 2px; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 16px;
            margin-bottom: 15px;
            color: #555;
        }

        .card-link {
            color: #fff;
            background-color: #3A8DDA;
            padding: 8px 15px;
            border-radius: 20px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .card-link:hover {
            background-color: #2b6cb0;
        }
        :root {
        --background-image-light: url('https://img.freepik.com/free-vector/stylish-line-pattern-background_361591-1140.jpg?t=st=1710924452~exp=1710928052~hmac=1ada2f85e49179a5932e354e068250c4896015b2ec0deab4548298d7fd8df42a&w=1380');
        --background-image-dark:#ffffff ;
    }
    .dark-mode .card {
    background-color: #626161; 
    color: #ffffff; 
}

.dark-mode .card-text{
    color:white;
}
    body {
        background-image: var(--background-image-light);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }

    body.dark-mode {
        background-image: var(--background-image-dark);
        color: #ffffff; /* Set text color for dark mode */
    }
</style>
<body class="hold-transition sidebar-mini layout-fixed" >
    <div class="wrapper">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Navbar left side -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Navbar brand -->
    <h2>My Favorites</h2>

    <!-- SEARCH FORM -->
    <div class="navbar-brand mx-auto"> <!-- Center the content horizontally -->
        <form class="form-inline">
            <div class="input-group input-group-sm" style="width: 300px; "> <!-- Increase width here -->
                 <input class="form-control form-control-navbar" style="background-color: #b0afaf; color: #333;" type="search" placeholder="Search" aria-label="Search" id="searchInput">
                <div class="input-group-append ">
                    <button class="btn btn-navbar" style="background-color: #b0afaf; "   type="button" onclick="searchContent()">
                        <i class="fas fa-search"  ></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script>
function searchContent() {
var input, filter, cards, card, title, i, txtValue;
input = document.getElementById('searchInput');
filter = input.value.toUpperCase();
cards = document.querySelectorAll('.card');
for (i = 0; i < cards.length; i++) {
    card = cards[i];
    title = card.querySelector('.card-title');
    txtValue = title.textContent || title.innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
        card.style.display = '';
    } else {
        card.style.display = 'none';
    }
}
}
</script>
    <!-- Navbar right side -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="details1.php"><i class="fas fa-plus-circle"
                    style="font-size: 30px; background-color: rgb(255, 255, 255); border-radius: 50%; color: #3A8DDA"></i></a>
        </li>
    </ul>
</nav>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
<div class="sidebar">
    <!-- User profile section -->
    <div class="image mt-4 pb-3 mb-3 d-flex">
        <img src="dist/img/user.jpg" class="user-image" alt="User Image">
    </div>
        <div class="info">
                    <?php
                    if (isset($_SESSION["username"])) {
                        echo '<a href="#" class="d-block justify-content-center text-dark text-bold">' . $_SESSION["username"] . '</a>';
                    } else {
                        echo '<a href="#" class="d-block justify-content-center text-dark text-bold">Guest</a>';
                    }
                    ?>
                </div>

            <br>
                <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'menu-open' : ''; ?>">
                    <a href="home.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>All Bookmarks</p>
                    </a>
                </li>
                <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'favourite.php' ? 'menu-open' : ''; ?>">
                            <a href="favourite.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'favourite.php' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-heart		"></i>
                                <p>My Favourites</p>
                            </a>
                        </li>
                <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'recipe.php' ? 'menu-open' : ''; ?>">
                    <a href="recipe.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'recipe.php' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-utensils"></i>
                        <p>Recipes</p>
                    </a>
                </li>
                <li class="nav-item has-treeview <?php echo basename($_SERVER['PHP_SELF']) == 'sports.php' ? 'menu-open' : ''; ?>">
                <a href="sports.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'sports.php' ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-basketball-ball"></i>
                <p>Sports</p>
                </a>
                </li>
                <li class="nav-item has-treeview <?php echo basename($_SERVER['PHP_SELF']) == 'news.php' ? 'menu-open' : ''; ?>">
                <a href="news.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'news.php' ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-newspaper"></i>
                <p>News</p>
                </a>
                </li>
                <li class="nav-item has-treeview <?php echo basename($_SERVER['PHP_SELF']) == 'meditation.php' ? 'menu-open' : ''; ?>">
                <a href="meditation.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'meditation.php' ? 'active' : ''; ?>">
                <i class="nav-icon fab fa-galactic-republic"></i>
                <p>Meditation</p>
                </a>
                </li>
                <li class="nav-item has-treeview <?php echo basename($_SERVER['PHP_SELF']) == 'travel.php' ? 'menu-open' : ''; ?>">
                <a href="travel.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'travel.php' ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-plane-departure"></i>
                <p>Travel</p>
                </a>
                </li>
                <br>
                        <br>
                        <div class="text-center">
                            <a href="category.html">
                                <button class="btn btn-primary" style="width: 200px; border-radius: 20px;">New Category</button></a>
                        </div>
                        <br>
                        <br>
                        <div class="text-center">
                            <a href="data.php">
                                <button class="btn btn-success" style="width: 200px; border-radius: 20px;">Manage Bookmark</button></a>
                        </div>
                        <br>
                        <br>
                        <!-- Toggle switch for dark mode -->
                        <div class="toggle-container ml-4">
                            <label class="switch">
                                <input type="checkbox" id="modeToggle" onchange="toggleDarkMode()">
                                <span class="slider round"></span>
                            </label>
                        </div>

                <script>
                // Function to toggle dark mode
                function toggleDarkMode() {
                const body = document.body;
                const isDarkMode = document.getElementById('modeToggle').checked;
                if (isDarkMode) {
                    body.classList.add('dark-mode');
                    // Store dark mode preference in local storage
                    localStorage.setItem('darkMode', 'enabled');
                } else {
                    body.classList.remove('dark-mode');
                    // Remove dark mode preference from local storage
                    localStorage.removeItem('darkMode');
                }
                }

                // Function to check and apply dark mode on page load
                function applyDarkModeOnLoad() {
                const isDarkMode = localStorage.getItem('darkMode');
                if (isDarkMode === 'enabled') {
                    document.getElementById('modeToggle').checked = true;
                    document.body.classList.add('dark-mode');
                }
                }

                // Call the function to apply dark mode on page load
                applyDarkModeOnLoad();
                </script>

                </ul>
                </nav>
                </div>
                </aside>
    <br>
    <div class="container">
        <div class="row">
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-4 mb-4'>";
                    echo "<div class='card position-relative'>";
                    if (!empty($row["detail_image"])) {
                        echo "<img src='uploads/{$row["detail_image"]}' class='card-img-top' alt='Image'>";
                    }
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>{$row["detail_name"]}</h5>";
                    echo "<p class='card-text'>{$row["detail_description"]}</p>";
                    echo "<a href='{$row["detail_url"]}' class='card-link'>Read More</a>";
                    // Add a button to remove from favorites if needed
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No favorite items found.</p>";
            }
            ?>
        </div>
    </div>
    <a href="home.php">Back to Home</a>
</body>

</html>
