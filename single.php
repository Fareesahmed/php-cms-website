<?php include 'header.php'; ?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <?php
                if (isset($_GET['id'])) {
                    $post_id = $_GET['id'];
                    include 'config.php'; // Make sure you include the database connection file

                    $sql = "SELECT *
                            FROM post
                            LEFT JOIN category ON post.category = category.category_id
                            LEFT JOIN user ON post.author = user.user_id
                            WHERE post.post_id = {$post_id}";

                    $res = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                ?>
                            <div class="post-container">
                                <div class="post-content single-post">
                                    <h3><?php echo $row['title']; ?></h3>
                                    <div class="post-information">
                                        <span>
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a href='category.php?cid=<?php echo $row['category_id']; ?>'><?php echo $row['category_name']; ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <a href='author.php?author_id=<?php echo $row['user_id']; ?>'><?php echo $row['username']; ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo $row['post_date']; ?>
                                        </span>
                                    </div>
                                    <img class="single-feature-image" src="admin/upload/<?php echo $row['post_img']; ?>" alt="<?php echo $row['title']; ?>" />
                                    <p class="description">
                                        <?php echo $row['description']; ?>
                                    </p>
                                </div>
                            </div>
                <?php
                        }
                    } else {
                        echo "<h2>No Post Found</h2>";
                    }
                } else {
                    echo "<h2>Invalid Post ID</h2>";
                }
                ?>
                <!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>