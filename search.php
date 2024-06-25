<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>

<body>
    

<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <?php
                    include("config.php");
                    $search_term = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                    // Display search term
                    echo "<h1 class='page-heading'>Search results for: " . strtoupper($search_term) . "</h1>";

                    $limit = 3;

                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;

                    $sql = "SELECT *
                            FROM post
                            LEFT JOIN category ON post.category = category.category_id
                            LEFT JOIN user ON post.author = user.user_id
                        
                            WHERE post.title LIKE '%{$search_term}%' or post.description LIKE '%{$search_term}%'
                            ORDER BY post.post_id DESC
                            LIMIT {$offset}, {$limit}";

                    $res = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                            <div class="post-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="post-img" href="single.php?id=<?php echo $row['post_id']; ?>"><img src="admin/upload/<?php echo $row['post_img']; ?>" alt="" /></a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="inner-content clearfix">
                                            <h3><a href='single.php?id=<?php echo $row['post_id']; ?>'><?php echo $row["title"]; ?></a></h3>
                                            <div class="post-information">
                                                <span>
                                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                                    <a href='category.php?cid=<?php echo $row['category_id']; ?>'><?php echo $row['category_name']; ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                    <a href='author.php?id=<?php echo $row['user_id']; ?>'><?php echo $row['username']; ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    <?php echo $row['post_date']; ?>
                                                </span>
                                            </div>
                                            <p class="description">
                                                <?php echo substr($row['description'], 0, 100) . '...'; ?>
                                            </p>
                                            <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']; ?>'>read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p style='color: green; text-align: center; margin: 10px 0; padding: 10px; border: 1px solid green; border-radius: 5px; background-color: #e6ffe6;'>No Posts Found!</p>";
                    }

                    // Pagination logic
                    $sql1 = "SELECT * FROM post WHERE title LIKE '%{$search_term}%' OR description LIKE '%{$search_term}%'";
                    $result1 = mysqli_query($conn, $sql1) or die("Error in pagination");

                    if (mysqli_num_rows($result1) > 0) {
                        $total_records = mysqli_num_rows($result1);
                        $total_page = ceil($total_records / $limit);

                        echo "<ul class='pagination admin-pagination'>";
                        for ($i = 1; $i <= $total_page; $i++) {
                            $active = ($i == $page) ? "active" : "";
                            echo "<li class='$active'><a href='search.php?search={$search_term}&page=$i'>$i</a></li>";
                        }
                        echo "</ul>";
                    }
                    ?>
                </div>
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
    </div>
</div>
</body>
</html>
<?php include 'footer.php'; ?>
