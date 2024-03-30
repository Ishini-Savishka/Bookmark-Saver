<?php


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database configuration
    $host = "localhost";
    $port = 5432;
    $dbname = "bookmark";
    $user = "ishini";
    $password = "lMwuIXErOpfPZu4ZcKk9thg00HPinX1f";

    // Create connection
    $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

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
    <title>Bookmark</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="dist/css/style.css">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#ffffff">
</head>

<style>
.card {
    width: 100%; 
    max-width: 1000px; 
}
.container{
    width:100%;
}
.card:hover {
    transform: translateY(-5px);
}
.card-body{
    background-color:#d3eaf2;
}

.card-img-overlay {
    background: rgba(0, 0, 0, 0.5);
    color: #fff;
    padding: 20px;
    border-radius: 0 0 10px 10px;
}

.card-title {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 10px;
}

.card-text {
    font-size: 18px;
    margin-bottom: 15px;
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
.like-icon {
    position: absolute;
    bottom: 10px;
    right: 10px;
}
.like-btn {
    border-radius:10px;
    background-color:transparent;
    color:white;
    border-color:transparent;

    }

</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <h2>All </h2>
            <!-- SEARCH FORM -->

            <div class="navbar-brand mx-auto">
                <form class="form-inline">
                    <div class="input-group input-group-sm" style="width: 300px; ">
                        <input class="form-control form-control-navbar" style="background-color: #b0afaf; color: #333;" type="search" placeholder="Search" aria-label="Search" id="searchInput">
                        <div class="input-group-append ">
                            <button class="btn btn-navbar" style="background-color: #b0afaf; " type="button" onclick="searchContent()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="text-center fs-6 mb-3 mt-3 ml-0">
                <form method="post">
                    <button type="submit" name="logout" class="btn btn-secondary">Logout</button>
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
        </nav>
        
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-primary elevation-4 ">
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="image mt-4 pb-3 mb-3 d-flex">
                    <img src="<?php echo isset($profileImage) ? $profileImage : 'dist/img/user.jpg'; ?>" class="user-image" alt="User Image">
                </div>

                <div class="info d-flex justify-content-between align-items-center">
                    <?php
                    if (isset($_SESSION["username"])) {
                        echo '<a href="#" class="text-dark text-bold">' . $_SESSION["username"] . '</a>';
                        echo '<a href="edit_profile.php" class="btn btn-warning"><i class="fas fa-user-edit"></i> Edit Profile</a>';
                    } else {
                        echo '<a href="#" class="text-dark text-bold">Guest</a>';
                    }
                    ?>
                </div>


                <br>
                <!-- Sidebar Menu -->
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
                        <br>
                        <br>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <div class="content-wrapper">
            <br>
            <!-- Content Header (Page header) -->
            <div class="container">
                <!-- Filter buttons -->
                <ul class="nav nav-pills justify-content-center font-weight-bold">
                <?php
                // Check if the user is logged in
                if (!isset($_SESSION['id'])) {
                    // User is logged in as a guest
                    echo "<li class='nav-item'></li>";
                } else {
                    // User is logged in
                    // Display the "All" category link
                    echo "<li class='nav-item'>
                            <a class='tab-link active' id='all' onclick='filterContent(\"all\")'>All</a>
                        </li>";

                    // Fetch category names from the database
                    $categoryNamesSql = "SELECT DISTINCT category_name FROM details";
                    $categoryNamesResult = $conn->query($categoryNamesSql);

                    if ($categoryNamesResult->num_rows > 0) {
                        while ($categoryNameRow = $categoryNamesResult->fetch_assoc()) {
                            $categoryName = $categoryNameRow['category_name'];
                            echo "<li class='nav-item'>";
                            echo "<a class='tab-link' id='$categoryName' onclick='filterContent(\"$categoryName\")'>$categoryName</a>";
                            echo "</li>";
                        }
                    } else {
                        echo "<li class='nav-item'></li>";
                    }
                }
                ?>
                </ul>
                <br>
                <!-- Gallery content -->
                <div id="content" class="row">
                <?php
if (!isset($_SESSION['id'])) {
    // User is not logged in (guest)
    // Display public content
    echo "<div class='container'>";
    echo "<h2>Welcome, Guest!</h2>";
    echo "</div>";

    // Advertisement Card for guests
    echo "<div class='card mb-4' style='background-color: #fff; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1); overflow: hidden;'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title text-center mb-4' style='color: #333;'>🎉 Join Our Community!</h5>";
    echo "<br>";
    echo "<br>";
    echo "<p class='card-text text-center' style='color: #666;'>You are currently browsing as a guest.</p>";
    echo "<p class='card-text text-center' style='color: #666;'>Unlock exclusive features by registering an account with us today! Experience a world of personalized bookmarks, tailored just for you.</p>";
    echo "<div class='text-center'>";
    echo "<a href='register.php' class='btn btn-primary btn-lg mt-5' style='border-radius: 30px; padding: 12px 30px; font-size: 18px;'>Get Started</a>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
} else {
    // Fetch details associated with the logged-in user from the database
    $userDetailsSql = "SELECT d.*, 
        CASE WHEN f.detail_id IS NOT NULL THEN '1' ELSE '0' END AS is_favorite
        FROM details d
        LEFT JOIN favorite_items f ON d.detail_id = f.detail_id
        LEFT JOIN users u ON d.id = u.id
        WHERE u.id = ?;
    ";

    $stmt = $conn->prepare($userDetailsSql);

    if (!$stmt) {
        die("Error: " . $conn->error); // Add error handling to display any SQL errors
    }

    $stmt->bind_param("i", $_SESSION["id"]); // Binding one integer parameter
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Display personalized content here
        while ($row = $result->fetch_assoc()) {
            echo "<div class='col-md-12 mb-4'>";
            echo "<div class='card position-relative' data-category-type='{$row["category_name"]}'>";
            if (!empty($row["detail_image"])) {
                echo "<img src='uploads/{$row["detail_image"]}' class='card-img-top' alt='Image'>";
            }
            echo "<div class='card-img-overlay'>";
            echo "<h5 class='card-title'>" . $row["detail_name"] . "</h5>";
            echo "<p class='card-text'>" . $row["detail_description"] . "</p>";
            echo "<a href='" . $row["detail_url"] . "' class='card-link'>Read More</a>";
            // Wrap the heart icon in a div for positioning
            echo "<div class='like-icon position-absolute bottom-0 end-0'>";
            // Inside the while loop where you output each item
            echo "<button class='like-btn' onclick='toggleLike(this)' data-detailId='" . htmlspecialchars($row["detail_id"], ENT_QUOTES) . "' data-liked='" . ($row["is_favorite"] == 1 ? 'true' : 'false') . "'>
            ";
            // Check if the item is in favorites and set the heart icon accordingly
            if ($row["is_favorite"] == 1) {
                echo "<i class='fas fa-heart fa-lg text-danger'></i>";
            } else {
                echo "<i class='far fa-heart fa-lg'></i>";
            }
            echo "</button>";

            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        // No bookmarks added for the logged-in user
        echo "<div class='container'>";
        echo "<p>No bookmarks added yet.</p>";
        echo "</div>";
    }
}
?>

                </div>
            </div>
            <br>
                            <?php
                // Check if the user is logged in
                if (isset($_SESSION['id'])) {
                    // Display the button for logged-in users
                    echo "<div class='text-center'>";
                    echo "<a href='details1.php'>";
                    echo "<button class='btn btn-info' style='width: 200px; border-radius: 20px;'>New Bookmark</button>";
                    echo "</a>";
                    echo "</div>";
                }
                ?>

                <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    
    <script>
        // Function to filter gallery content based on category
        function filterContent(categoryName) {
            // Remove active class from all filter buttons
            document.querySelectorAll('.tab-link').forEach(link => {
                link.classList.remove('active');
            });

            // Add active class to the clicked filter button
            document.getElementById(categoryName).classList.add('active');

            // Reset display property of all gallery items
            document.querySelectorAll('.card').forEach(card => {
                card.style.display = 'none';
            });

            if (categoryName === 'all') {
                // If 'All' tab is selected, show all gallery items
                document.querySelectorAll('.card').forEach(card => {
                    card.style.display = 'block';
                });
            } else {
                // Filter and show gallery items based on the selected category
                document.querySelectorAll(`.card[data-category-type="${categoryName}"]`).forEach(card => {
                    card.style.display = 'block';
                });
            }
        }
    </script>

<script>
// Function to toggle like status
function toggleLike(button) {
    // Retrieve detailId and liked status from the button's data attributes
    const detailId = button.getAttribute('data-detailId');
    const isLiked = button.getAttribute('data-liked') === 'true';

    // Send AJAX request to toggle like status
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_like.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log('Response:', xhr.responseText);
            // Update heart icon based on response
            if (xhr.responseText === 'added') {
                // Item added to favorites, fill heart icon
                button.innerHTML = '<i class="fas fa-heart fa-lg text-danger"></i>';
                button.setAttribute('data-liked', 'true');
            } else if (xhr.responseText === 'removed') {
                // Item removed from favorites, outline heart icon
                button.innerHTML = '<i class="far fa-heart fa-lg"></i>';
                button.setAttribute('data-liked', 'false');
            }
        } else {
            console.error('Request failed. Returned status of ' + xhr.status);
        }
    };

    // Send the detailId and action as parameters
    xhr.send('detailId=' + detailId + '&action=toggle'); // Ensure detailId is included
}

</script>




    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>
