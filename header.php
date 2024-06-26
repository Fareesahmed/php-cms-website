<?php
include("config.php");

// Initialize the title variable
$title = "News";

// Determine the page context to set a dynamic title using switch case
$page_type = '';
if (isset($_GET['cid'])) {
    $page_type = 'category';
} elseif (isset($_GET['search'])) {
    $page_type = 'search';
} elseif (isset($_GET['author_id'])) {
    $page_type = 'author';
} elseif (isset($_GET['id'])) {
    $page_type = 'single';
} else {
    $page_type = 'home';
}

switch ($page_type) {
    case 'category':
        // Fetch category name based on category ID (cid)
        $cat_id = $_GET['cid'];
        $sql = "SELECT category_name FROM category WHERE category_id = {$cat_id}";
        $res = mysqli_query($conn, $sql);
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $title = $row['category_name'] . " - News";
        } else {
            $title = "Category not found - News";
        }
        break;

    case 'search':
        // Set the title for the search page
        $search_term = mysqli_real_escape_string($conn, $_GET['search']);
        $title = "Search results for " . strtoupper($search_term) . " - News";
        break;

    case 'author':
        // Fetch author name based on author ID
        $author_id = $_GET['author_id'];
        $author_sql = "SELECT username FROM user WHERE user_id = {$author_id}";
        $author_res = mysqli_query($conn, $author_sql);
        if ($author_res && mysqli_num_rows($author_res) > 0) {
            $author_row = mysqli_fetch_assoc($author_res);
            $author_name = $author_row['username'];
            $title = "Posts by " . strtoupper($author_name) . " - News";
        } else {
            $title = "Author not found - News";
        }
        break;

    case 'single':
        // Fetch post title based on post ID (id)
        $post_id = $_GET['id'];
        $post_sql = "SELECT title FROM post WHERE post_id = {$post_id}";
        $post_res = mysqli_query($conn, $post_sql);
        if ($post_res && mysqli_num_rows($post_res) > 0) {
            $post_row = mysqli_fetch_assoc($post_res);
            $title = $post_row['title'] . " - News";
        } else {
            $title = "Post not found - News";
        }
        break;

    case 'home':
    default:
        $title = "Home - News";
        break;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible"="ie=edge">
    <title><?php echo $title; ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class=" col-md-offset-4 col-md-4">
                    <a href="index.php" id="logo"><img src="images/news.jpg" alt="Logo"></a>
                </div>
                <!-- /LOGO -->
            </div>
        </div>
    </div>
    <!-- /HEADER -->
    <!-- Menu Bar -->
    <div id="menu-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $cat_id = isset($_GET['cid']) ? $_GET['cid'] : null;

                    $sql = "SELECT * FROM category WHERE post > 0";
                    $res = mysqli_query($conn, $sql) or die("Failed to execute Query");
                    if (mysqli_num_rows($res) > 0) {
                    ?>
                        <ul class='menu'>
                            <?php
                            while ($row = mysqli_fetch_assoc($res)) {
                                $active = ($row['category_id'] == $cat_id) ? "active" : "";
                                echo "<li class='{$active}'><a href='category.php?cid={$row['category_id']}'>{$row['category_name']}</a></li>";
                            }
                            ?>
                        </ul>
                    <?php } 
                  ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /Menu Bar -->
</body>

</html>
