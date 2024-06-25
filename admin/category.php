<?php include "header.php";

if ($_SESSION['role'] == 0) {
    header("Location:{$hostname}/admin/post.php");
}

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <?php

                $limit = 3;
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                $offset = ($page - 1) * $limit;
                $sql = "Select * from category order by category_id desc limit {$offset},{$limit}";
                $res = mysqli_query($conn, $sql);
                if (mysqli_num_rows($res) > 0) {

                ?>
                    <table class="content-table">
                        <thead>
                            <th>S.No.</th>
                            <th>Category Name</th>
                            <th>No. of Posts</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($res)) {

                            ?>
                                <tr>
                                    <td class='id'><?php echo $row["category_id"] ?></td>
                                    <td><?php echo $row["category_name"]  ?></td>
                                    <td><?php echo $row["post"] ?></td>
                                    <td class='edit'><a href='update-category.php?id=<?php echo $row["category_id"]; ?>'><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-category.php?id=<?php echo $row["category_id"]; ?>'><i class='fa fa-trash-o'></i></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } 
                $sql1 = "Select * from category";
                $result1 = mysqli_query($conn, $sql1) or die("Error in pagination");
                if (mysqli_num_rows($result1) > 0) {
                    $total_records = mysqli_num_rows($result1);

                    $total_page = ceil($total_records / $limit);
                    echo " <ul class='pagination admin-pagination'>";
                    for ($i = 1; $i <= $total_page; $i++) {
                        $active = ($i == $page) ? "active" : "";
                        echo "<li class='$active'><a href='category.php?page=$i'>$i</a></li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p style='color: green; text-align: center; margin: 10px 0; padding: 10px; border: 1px solid green; border-radius: 5px; background-color: #e6ffe6;'>No Category!</p>";
                }
                
                ?>

                
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>