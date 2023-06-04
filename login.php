<?php
    include 'config.php';
    session_start();
    if(isset($_SESSION['username'])){
        header('location:index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="./CSS/login.css">
</head>

<body>

    <?php
        if(isset($_POST['submit'])){
            $email    = $_POST['email']; 
            $password = $_POST['password'];
            $error = "";
            
            $query = "SELECT * FROM `user_tbl` WHERE email='$email' AND password='$password'";
            $result = mysqli_query($conn,$query);
            $row = mysqli_fetch_assoc($result);

            if($row > 0){
                header('location:index.php');
                $_SESSION['username'] = $row['fullname'];
            }
            else{
                $error = "Incorrect email or password !!";
            }
        }
    ?>

    <div class="wrapper">
        <h1>Log In</h1>
        <form action="" method="POST" onsubmit="return validateForm();">

            <div>
                <?php if(isset($error)){ ?>
                <p class="error"><?php echo $error;?></p>
                <?php }?>
            </div>

            <div class="fields">
                <input type="email" name="email" placeholder="Enter your email">
                <input type="password" name="password" placeholder="Enter your password">
            </div>
            <input type="submit" name="submit" class="btn" value="Login">
            <div>
                <p>OR</p>
                <h4><a href="adduser.php">Sign Up</a></h4>
            </div>
            <a href="home.php">Back To Home</a>
        </form>
    </div>

    <script>
    function validateForm() {
        const email = document.querySelector('input[type="email"]').value;
        const password = document.querySelector('input[type="password"]').value;

        if (email == "") {
            alert("Please enter your email.");
            return false;
        }

        if (password == "") {
            alert("Please enter your password.");
            return false;
        }

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert("Please enter a valid email address.");
            return false;
        }

        if (!password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/)) {
            alert(
                'Password should be 8 to 15 characters long and should contain at least one lowercase letter, one uppercase letter, one number, and one special character.'
                );
            return false;
        }

        return true;
    }
    </script>
</body>

</html>