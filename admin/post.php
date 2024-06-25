<?php
include "header.php";
include "config.php"; // Include database connection

// delete logic
if (isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id']) && isset($_GET['category_name'])) {
    $post_id = $_GET['id'];
    $cat_name = $_GET['category_name'];

    $delImg="SELECT * FROM post  WHERE post_id={$post_id}";
    $resImg=mysqli_query($conn,$delImg) or die("Image Query Failed");
    $rowImg=mysqli_fetch_assoc($resImg);
    
    unlink("upload/".$rowImg['post_img']);

    // Delete post query
    $delSql = "DELETE FROM post WHERE post_id={$post_id};";
    
    // Decrement post count in category table
    $delSql .= "UPDATE category SET post = post - 1 WHERE category_name='{$cat_name}'";
    
    // Execute multi query
    if (mysqli_multi_query($conn, $delSql)) {
        do {
            // Store the first result set
            if ($result = mysqli_store_result($conn)) {
                mysqli_free_result($result);
            }
        } while (mysqli_next_result($conn));
    } else {
        die("Failed to delete");
    }
    
    header("Location:" . $_SERVER['PHP_SELF']);
    exit();
}

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Posts</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-post.php">add post</a>
            </div>
            <div class="col-md-12">
                <?php
                $limit = 8;
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }

                $offset = ($page - 1) * $limit;

                if ($_SESSION['role'] == 1) {
                    $sql = "SELECT post.post_id, post.title, category.category_name, post.post_date, user.username 
                            FROM post
                            LEFT JOIN category ON post.category = category.category_id
                            LEFT JOIN user ON post.author = user.user_id
                            ORDER BY post.post_id DESC
                            LIMIT {$offset}, {$limit}";
                } elseif ($_SESSION['role'] == 0) {
                    $userId = mysqli_real_escape_string($conn, $_SESSION['user_id']);
                    $sql = "SELECT post.post_id, post.title, category.category_name, post.post_date, user.username 
                            FROM post
                            LEFT JOIN category ON post.category = category.category_id
                            LEFT JOIN user ON post.author = user.user_id
                            WHERE post.author = {$userId}
                            ORDER BY post.post_id DESC
                            LIMIT {$offset}, {$limit}";
                }

                $res = mysqli_query($conn, $sql);
                if (mysqli_num_rows($res) > 0) {
                ?>
                    <table class="content-table">
                        <thead>
                            <th>S.No.</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Author</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($res)) {  ?>
                                <tr>
                                    <td class='id'><?php echo $row["post_id"]; ?></td>
                                    <td><?php echo $row["title"]; ?></td>
                                    <td><?php echo $row["category_name"]; ?></td>
                                    <td><?php echo $row["post_date"]; ?></td>
                                    <td><?php echo $row["username"]; ?></td>
                                    <td class='edit'><a href='update-post.php?id=<?php echo $row5["post_id"]; ?>'><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'>
                                        <a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=delete&id=<?php echo $row["post_id"]; ?>&category_name=<?php echo $row["category_name"]; ?>'>
                                            <i class='fa fa-trash-o'></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php  } ?>
                        </tbody>
                    </table>
                <?php
                } else {
                    echo "<p style='color: green; text-align: center; margin: 10px 0; padding: 10px; border: 1px solid green; border-radius: 5px; background-color: #e6ffe6;'>No Posts!</p>";
                }

                if ($_SESSION['role'] == 1) {
                    $sql1 = "SELECT * FROM post";
                } elseif ($_SESSION['role'] == 0) {
                    $userId = mysqli_real_escape_string($conn, $_SESSION['user_id']);
                    $sql1 = "SELECT * FROM post WHERE post.author = {$userId}";
                }

                $result1 = mysqli_query($conn, $sql1) or die("Error in pagination");
                if (mysqli_num_rows($result1) > 0) {
                    $total_records = mysqli_num_rows($result1);
                    $total_page = ceil($total_records / $limit);
                    echo "<ul class='pagination admin-pagination'>";
                    for ($i = 1; $i <= $total_page; $i++) {
                        $active = ($i == $page) ? "active" : "";
                        echo "<li class='$active'><a href='post.php?page=$i'>$i</a></li>";
                    }
                    echo "</ul>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>