
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

// Retrieve data from the category table
$sql = "SELECT category_name FROM category";
$result = $conn->query($sql);
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
  body.dark-mode {
    background-image: url(dist/img/bg-dark.png); 
    color: white; 
  }

  body {
    background-image: url(dist/img/bg.png) ;
    background-repeat: no-repeat;
    background-size: cover;
    color: black; 
  }

  .h2 {
    text-align: center;
  }

  .dark-mode .wrapper,
  .dark-mode .container {
    background-color: #272727; 
    color: white; 
  }
  .equal-size-btn {
        width: 100px; 
    }
</style>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-light custom-navbar">
    <!-- Three bars icon -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>
</nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">


    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
        <div class="image mt-4 pb-3 mb-3 d-flex">
          <img src="dist/img/user.jpg" class="user-image" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block justify-content-center text-dark text-bold">Ishini Gamage</a>
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

<!-- Add Category Section -->
<div class="container mt-4 col-md-7">
  <h2 class="h2">Add Details</h2>

  <div class="container mt-5">
    <div class="row">
      <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
        <div class="card-details">
          <div class="card-body">
            <form action="insert_details.php" method="post" enctype="multipart/form-data">
              <div class="mb-3 row">
                <label for="itemName" class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="itemName" name="detail_name" placeholder="Enter detail name">
                </div>
              </div>
              <br>
              <div class="mb-3 row">
                <label for="itemDescription" class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-9">
                  <textarea class="form-control" id="itemDescription" name="detail_description" placeholder="Enter detail description"></textarea>
                </div>
              </div>
              <br>
              <div class="mb-3 row">
                <label for="itemURL" class="col-sm-3 col-form-label">URL</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="itemURL" name="detail_url" placeholder="Enter detail URL">
                </div>
              </div>
              <br>
              <div class="mb-3 row">
                <label for="imageUploader" class="col-sm-3 col-form-label">Upload Image</label>
                <div class="col-sm-9">
                  <input type="file" class="form-control" id="imageUploader" name="detail_image">
                </div>
              </div>
              <br>
              <div class="mb-3 row">
                <label for="categoryName" class="col-sm-3 col-form-label">Category Name</label>
                <div class="col-sm-9">
                    <select class="form-control" id="categoryName" name="category_name">
                        <option value="" selected disabled>Select Category</option>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['category_name'] . "'>" . $row['category_name'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No categories found</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
           
              <div class="mb-3 row">
                <label for="categoryType" class="col-sm-3 col-form-label">Category Type</label>
                <div class="col-sm-9">
                  <select class="form-control" id="categoryType" name="category_type">
                    <option value="" selected disabled>Select Category Type</option>
                    <option value="Videos">Videos</option>
                    <option value="Music">Music</option>
                    <option value="Blog">Blog</option>
                    <option value="Photo">Photo</option>
                  </select>
                </div>
              </div>
  
              <br>
              <div class="text-center">
              <button type="button" class="btn btn-danger text-bold mr-4 equal-size-btn" onclick="history.back()">Cancel</button>
              <button type="submit" class="btn btn-success ml-4 text-bold equal-size-btn">Save</button>

              </div>
            </form>
  
          </div>
        </div>
      </div>
    </div>
  </div>
  


  
   
  
  <!-- Your add category content here -->
</div>
<!-- End Add Category Section -->



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
