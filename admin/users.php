<?php include "header.php";
include('config.php');


if ($_SESSION['role']==0) {
    header("Location:{$hostname}/admin/post.php");
}



if (isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "delete from user where user_id={$user_id}";
    $res = mysqli_query($conn, $sql) or die("Failed to delete");
    header("Location:" . $_SERVER['PHP_SELF']);
    exit();
}


?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Users</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-user.php">add user</a>
            </div>
            <div class="col-md-12">
                <?php
                include("config.php");
                $limit = 3;
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                $offset = ($page - 1) * $limit;
                $sql = "Select * from user order by user_id desc limit {$offset},{$limit}";
                $res = mysqli_query($conn, $sql);
                if (mysqli_num_rows($res) > 0) {

                ?>
                    <table class="content-table">
                        <thead>
                            <th>S.No.</th>
                            <th>Full Name</th>
                            <th>User Name</th>
                            <th>Role</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($res)) {  ?>
                                <tr>
                                    <td class='id'> <?php echo $row["user_id"] ?></td>
                                    <td> <?php echo $row["first_name"] . " " . $row["last_name"] ?></td>
                                    <td> <?php echo $row["username"] ?></td>
                                    <td> <?php echo $row["role"] == 1 ? "Admin" : "User" ?></td>
                                    <td class='edit'><a href='update-user.php?id=<?php echo $row["user_id"]; ?>'><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=delete&id=<?php echo $row["user_id"]; ?>'><i class='fa fa-trash-o'></i></a></td>
                                </tr>
                            
                            <?php  } ?>
                        </tbody>
                    </table>
                <?php }
                $sql1 = "Select * from user";
                $result1 = mysqli_query($conn, $sql1) or die("Error in pagination");
                if (mysqli_num_rows($result1) > 0) {
                    $total_records = mysqli_num_rows($result1);

                    $total_page = ceil($total_records / $limit);
                    echo " <ul class='pagination admin-pagination'>";
                    for ($i = 1; $i <= $total_page; $i++) {
                        $active = ($i == $page) ? "active" : "";
                        echo "<li class='$active'><a href='users.php?page=$i'>$i</a></li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p style='color: green; text-align: center; margin: 10px 0; padding: 10px; border: 1px solid green; border-radius: 5px; background-color: #e6ffe6;'>No Users!</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer   .php"; ?>