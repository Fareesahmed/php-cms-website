<?php
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>News</title>
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