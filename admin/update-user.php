<?php include "header.php";
if (isset($_POST['submit'])) {
    include("config.php");
    $fname = mysqli_escape_string($conn, $_POST['fname']);
    $lname = mysqli_escape_string($conn, $_POST['lname']);
    $user = mysqli_escape_string($conn, $_POST['username']);
    $user_id = mysqli_escape_string($conn, $_POST['user_id']);
    $role = mysqli_escape_string($conn, $_POST['role']);

    $sql = "update user set first_name='{$fname}',last_name='{$lname}',username='{$user}',role='{$role}' where user_id='{$user_id}'";
    $res = mysqli_query($conn, $sql) or die("USer not updated");
    echo "<p style='color:green;text-align:center;margin:10px 0;'>User Updated!</p>";
    header("refresh:1; url={$hostname}/admin/users.php");
}


?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Modify User Details</h1>
            </div>
            <div class="col-md-offset-4 col-md-4">
                <?php
                include("config.php");
                $user_id = $_GET['id'];
                $sql = "SELECT * FROM user WHERE user_id={$user_id}";
                $res = mysqli_query($conn, $sql) or die("Fetch error");

                if (mysqli_num_rows($res) > 0) {
                    $row = mysqli_fetch_assoc($res);
                ?>
                    <!-- Form Start -->
                    <form action="" method="POST">
                        <div class="form-group">
                            <input type="hidden" name="user_id" class="form-control" value="<?php echo $row["user_id"]; ?>" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="fname" class="form-control" value="<?php echo $row["first_name"]; ?>" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="lname" class="form-control" value="<?php echo $row["last_name"]; ?>" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label>User Name</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $row["username"]; ?>" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label>User Role</label>
                            <select class="form-control" name="role" required>
                                <option value="0" <?php if ($row['role'] == 0) echo 'selected'; ?>>Normal User</option>
                                <option value="1" <?php if ($row['role'] == 1) echo 'selected'; ?>>Admin</option>
                            </select>
                        </div>
                        <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                    </form>
                <?php
                } else {
                    echo "<p>User not found.</p>";
                }
                ?>
                <!-- /Form -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>