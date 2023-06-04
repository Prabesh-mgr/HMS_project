<?php
    include 'config.php';
    session_start();
    if(!isset($_SESSION['username']))
    header('location:login.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Dispaly Page</title>
    <link rel="stylesheet" href="./CSS/style.css">
</head>

<body>
    <header>
        <form action="index.php" method="POST">
            <div class="navbar">
                <ul class="menu">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="adduser.php">Add User</a></li>
                    <li><a href="index.php">All Users</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
                <div class="searchbox">
                    <input type="text" name="search"><input class="search" type="submit" value="Search">
                </div>
            </div>
        </form>
    </header>

    <table border=1 rules="all">
        <h1>All Records</h1>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Gender</th>
            <th>DOB</th>
            <th>Profile Picture</th>
            <th>Password</th>
            <th colspan="2">Action</th>
        </tr>

        <?php
            $search = "%";
            if(isset($_POST['search'])){
                $search = $search.$_POST['search'];
            }
            $search.= "%";
            $select = "SELECT * FROM user_tbl where fullname like '".$search."'";
            $result = mysqli_query($conn, $select);
        
            if($result){
                while($row = mysqli_fetch_assoc($result)){
                    echo '
                    <tr>
                        <td>'.$row['id'].'</td>
                        <td>'.$row['fullname'].'</td>
                        <td>'.$row['mobile'].'</td>
                        <td>'.$row['email'].'</td>
                        <td>'.$row['gender'].'</td>
                        <td>'.$row['dob'].'</td>
                        <td><img src="uploadedImages/'.$row['pp'].'" width="100"></td>
                        <td>'.$row['password'].'</td>
                        <td>
                            <div class="operation">
                                <a class="edit" href="update.php?updateid='.$row['id'].'">Edit/Update</a>
                                <a class="delete" href="delete.php?deleteid='.$row['id'].'">Delete</a>                            
                            </div>
                        </td>
                    </tr>
                    ';
                }
            }
        ?>
    </table>

</body>

</html>