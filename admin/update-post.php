<?php 
include "header.php"; 
include "config.php"; // Include database connection

if(isset($_GET['id'])){
    $post_id = $_GET['id'];
    $sql = "SELECT * FROM post
            LEFT JOIN category ON post.category = category.category_id
            LEFT JOIN user ON post.author = user.user_id
            WHERE post.post_id = {$post_id}";
    $res = mysqli_query($conn, $sql) or die("Error in fetching data");

    if(mysqli_num_rows($res) > 0){
        $row = mysqli_fetch_assoc($res);
    } else {
        echo "<p style='color: red; text-align: center; margin: 10px 0;'>Post not found!</p>";
    }
}

// Update post logic
if(isset($_POST['submit'])){
    $post_id = mysqli_real_escape_string($conn, $_POST['post_id']);
    $title = mysqli_real_escape_string($conn, $_POST['post_title']);
    $desc = mysqli_real_escape_string($conn, $_POST['postdesc']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $old_image = mysqli_real_escape_string($conn, $_POST['old-image']);
    
    if(!empty($_FILES['new-image']['name'])){
        $image_name = $_FILES['new-image']['name'];
        $image_tmp_name = $_FILES['new-image']['tmp_name'];
        $image_size = $_FILES['new-image']['size'];
        $image_type = $_FILES['new-image']['type'];
        $image_ext = strtolower(end(explode('.', $image_name)));
        $extensions = array("jpeg", "jpg", "png");

        if(in_array($image_ext, $extensions) === false){
            $errors[] = "This file extension is not allowed, please upload a JPG or PNG file.";
        }
        if($image_size > 5242880){
            $errors[] = "File size must be less than 5 MB";
        }
        if(empty($errors) == true){
            move_uploaded_file($image_tmp_name, "upload/".$image_name);
        } else {
            foreach($errors as $error){
                echo "<p style='color: red; text-align: center; margin: 10px 0;'>{$error}</p>";
            }
            die();
        }
    } else {
        $image_name = $old_image;
    }

    $sql = "UPDATE post SET 
            title = '{$title}', 
            description = '{$desc}', 
            category = {$category}, 
            post_img = '{$image_name}' 
            WHERE post_id = {$post_id}";

    if(mysqli_query($conn, $sql)){
        header("Location: {$hostname}/admin/post.php");
    } else {
        echo "<p style='color: red; text-align: center; margin: 10px 0;'>Query Failed!</p>";
    }
}

?>
<div id="admin-content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
      </div>
      <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
          <div class="form-group">
            <input type="hidden" name="post_id" class="form-control" value="<?php echo $row['post_id']; ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputTile">Title</label>
            <input type="text" name="post_title" class="form-control" id="exampleInputUsername" value="<?php echo $row['title']; ?>" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1"> Description</label>
            <textarea name="postdesc" class="form-control" required rows="5"><?php echo $row['description']; ?></textarea>
          </div>
          <div class="form-group">
            <label for="exampleInputCategory">Category</label>
            <select class="form-control" name="category" required>
              <option value="">Select Category</option>
              <?php
              $category_sql = "SELECT * FROM category";
              $category_res = mysqli_query($conn, $category_sql) or die("Category Query Failed.");
              while($category_row = mysqli_fetch_assoc($category_res)){
                  $selected = $row['category'] == $category_row['category_id'] ? "selected" : "";
                  echo "<option {$selected} value='{$category_row['category_id']}'>{$category_row['category_name']}</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="">Post image</label>
            <input type="file" name="new-image">
            <img src="upload/<?php echo $row['post_img']; ?>" height="150px">
            <input type="hidden" name="old-image" value="<?php echo $row['post_img']; ?>">
          </div>
          <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
        <!-- Form End -->
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
