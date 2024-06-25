<?php
include("header.php");
include("config.php");

if (isset($_POST['save'])) {
    $cat = $_POST['cat'];

    // Check if category already exists
    $check_sql = "SELECT * FROM category WHERE category_name = '{$cat}'";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) > 0) {
        // Category already exists
        echo "<p style='color:red;text-align:center;margin:10px 0;'>Category Already Exists!</p>";
    } else {
        // Insert new category
        $sql = "INSERT INTO category (category_name) VALUES ('{$cat}')";
        $res = mysqli_query($conn, $sql) or die("Error in adding category");

        if ($res) {
            echo "<p style='color:green;text-align:center;margin:10px 0;'>Category Created!</p>";
            header("refresh:0.5; url={$hostname}/admin/category.php");
        }
    }
}
?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add New Category</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form Start -->
                <form action="" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="cat" class="form-control" placeholder="Category Name" required>
                    </div>
                    <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                </form>
                <!-- /Form End -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>