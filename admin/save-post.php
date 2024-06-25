<?php
include("config.php");
session_start(); // Start the session at the beginning

if (isset($_POST['submit'])) {

    if (isset($_FILES['fileToUpload'])) {
        $errors = array();

        $fileName = $_FILES['fileToUpload']['name'];
        $fileSize = $_FILES['fileToUpload']['size'];
        $fileTmpName = $_FILES['fileToUpload']['tmp_name'];
        $fileType = $_FILES['fileToUpload']['type'];

        $fileExtArr = explode(".", $fileName);
        $fileExt = strtolower(end($fileExtArr)); 

        $allowedExts = array("jpg", "jpeg", "png", "gif");
        if (in_array($fileExt, $allowedExts) === false) {
            $errors[] = "Extension not allowed, please choose a JPG, JPEG, PNG, or GIF file.";
        }

        if ($fileSize > 5242880) {
            $errors[] = "File size must be less than 5 MB";
        }

        if (empty($errors) == true) {
            move_uploaded_file($fileTmpName, "upload/" . $fileName);
        } else {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
            exit();
        }
    }

    $title = mysqli_real_escape_string($conn, $_POST['post_title']);
    $desc = mysqli_real_escape_string($conn, $_POST['postdesc']);
    $cat = mysqli_real_escape_string($conn, $_POST['category']);
    $date = date("d M, Y");
    $author = $_SESSION['user_id'];

    $sql = "INSERT INTO post (title, description, category, post_date, author, post_img) 
            VALUES ('{$title}', '{$desc}', '{$cat}', '{$date}', '{$author}', '{$fileName}');";
    $sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$cat}";

    if (mysqli_multi_query($conn, $sql)) {
        header("Location:{$hostname}/admin/post.php");
    } else {
        echo "Multi query failed: " . mysqli_error($conn);
    }
}
?>
