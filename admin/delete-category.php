<?php  
include("config.php");
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $sql = "DELETE FROM category WHERE category_id = {$id}";
    $res = mysqli_query($conn, $sql) or die("Error in deleting the category");
    header("refresh:0; url={$hostname}/admin/category.php");
}



?>