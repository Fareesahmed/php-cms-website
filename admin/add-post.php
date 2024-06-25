<?php include "header.php"; ?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add New Post</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form -->
                <form action="save-post.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="post_title">Title</label>
                        <input type="text" name="post_title" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"> Description</label>
                        <textarea name="postdesc" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Category</label>
                        <select name="category" class="form-control">
                            <option disabled selected> Select Category</option>
                            <?php
                            include("config.php");
                            $sqlForCat = "select * from category";
                            $res = mysqli_query($conn, $sqlForCat) or die("Error fetching category");
                            if (mysqli_num_rows($res) > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo "  <option value='{$row['category_id']}' >{$row['category_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Post image</label>
                        <input type="file" name="fileToUpload" required>
                    </div>
                    <input id="file" type="submit" name="submit" class="btn btn-primary" value="Save" required accept="image/*" />
                </form>
                <!--/Form -->
            </div>
        </div> 
    </div>
</div>
    <script>
        document.getElementById('file').addEventListener('change', function() {
            const file = this.files[0];
            if (file.size > 5 * 1024 * 1024) { // 5MB in bytes
                alert('File size exceeds 5 MB');
                this.value = ''; // Clear the input value
            }
        });
    </script>

<?php include "footer.php"; ?>