<?php
session_start();

// Check if the logout button is clicked
if (isset($_POST["logout"])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to index.php or any other page after logout
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
?>
<!DOCTYPE html>
<html>
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
    width: 100%; /* Set the width to 100% to occupy the entire column */
    max-width: 600px; /* Set a maximum width for the cards */
}

    .card:hover {
        transform: translateY(-5px);
    }
    .card-img-overlay {
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
        padding: 20px;
        border-radius: 0 0 10px 10px;
    }
    .card-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .card-text {
        font-size: 14px;
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
    </style>
<body class="hold-transition sidebar-mini layout-fixed">
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
            <h2>Meditation</h2>

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


    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
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
<!-- Selectable Titles -->
<ul class="nav nav-pills justify-content font-weight-bold">
  <li class="nav-item">
    <a class="tab-link active" id="all" onclick="filterContent('all')">All</a>
  </li>
  <?php
          // Fetch distinct category types from the database
          $sql = "SELECT DISTINCT category_type FROM details";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  $categoryType = $row['category_type'];
                  echo "<li class='nav-item'>";
                  echo "<a class='tab-link' id='$categoryType' onclick=\"filterContent('$categoryType')\">" . ucfirst($categoryType) . "</a>";
                  echo "</li>";
              }
          }
        ?>
</ul>
<br>

  <br>

  <!-- Content Section -->
  <div class="row" id="content">
  <?php
// Fetch details for the "recipe" category associated with the logged-in user from the database
$category_name = "meditation"; // Set the category name to "recipe"
$user_id = $_SESSION["id"]; // Retrieve the user's ID from the session

// Modify the SQL query to join with the users table and filter by the user's ID
$categorySql = "SELECT d.*, 
                    CASE WHEN f.detail_id IS NOT NULL THEN '1' ELSE '0' END AS is_favorite
                FROM details d
                LEFT JOIN favorite_items f ON d.detail_id = f.detail_id AND f.id = ?
                LEFT JOIN users u ON d.id = u.id
                WHERE d.category_name = ? AND u.id = ?";
$stmt = $conn->prepare($categorySql);
if (!$stmt) {
    die("Error: " . $conn->error); // Add error handling to display any SQL errors
}
$stmt->bind_param("isi", $user_id, $category_name, $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='col-md-10'>"; // Start a new column (two columns in total)
        echo "<div class='card' data-category-type='{$row["category_type"]}'>"; // Add data-category-type attribute
        if (!empty($row["detail_image"])) {
            echo "<img src='uploads/{$row["detail_image"]}' class='card-img-top' alt='Image'>";
        }
        echo "<div class='card-img-overlay'>";
        echo "<h5 class='card-title'>" . $row["detail_name"] . "</h5>";
        echo "<p class='card-text'>" . $row["detail_description"] . "</p>";
        echo "<a href='" . $row["detail_url"] . "' class='card-link'>Read More</a>";
        echo "</div>";
        echo "</div>";
        echo "</div>"; // End column
    }
} else {
    echo "No results found for the category 'Meditation' associated with the logged-in user.";
}
$stmt->close();
?>
        </div>
</div>

</div>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>

  <!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<script>
  // Filter and display content based on type
  function filterContent(categoryType) {
    console.log('Filtering content for type:', categoryType);

    // Remove active class from all nav links
    document.querySelectorAll('.tab-link').forEach(link => {
      link.classList.remove('active');
    });

    // Add active class to the clicked nav link
    document.getElementById(categoryType).classList.add('active');

    // Show all cards initially
    document.querySelectorAll('.card').forEach(card => {
      card.style.display = 'block';
    });

    // Filter cards based on category type
    if (categoryType !== 'all') {
      document.querySelectorAll('.card').forEach(card => {
        if (card.getAttribute('data-category-type') !== categoryType) {
          card.style.display = 'none';
        }
      });
    }
  }

  // Initially display all content
  filterContent('all');
</script>


<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
