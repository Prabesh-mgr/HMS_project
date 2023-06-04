<?php
    include 'config.php';

    if(isset($_GET['deleteid'])){
        $id = $_GET['deleteid'];
        $query = "DELETE FROM user_tbl WHERE id = $id";
        $result = mysqli_query($conn,$query);

        header('location:index.php');
    }
?>