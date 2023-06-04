<?php
    include 'config.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="./CSS/adduser.css">
</head>

<body>
    <div class="wrapper">
        <h1>Add User</h1>
        <form name="myForm" action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
            <div class="container">
                <div class="row">
                    <label for="name">Fullname</label>
                    <input class="inputField" type="text" name="fullname" placeholder="Enter Your Fullname">
                </div>

                <div class="row">
                    <label for="mobile">Mobile</label>
                    <input class="inputField" type="tel" name="mobile" placeholder="Enter Your Mobile Number">
                </div>

                <div class="row">
                    <label for="email">Email</label>
                    <input class="inputField" type="email" name="email" placeholder="Enter Your Email">
                </div>


                <div class="row">
                    <label for="gender">Gender</label>
                    <input type="radio" name="gender[]" value="Male">
                    <span>Male</span>
                    <input type="radio" name="gender[]" value="Female">
                    <span>Female</span>
                    <input type="radio" name="gender[]" value="Others">
                    <span>Others</span>
                </div>

                <div class="row">
                    <label for="dob">Date of Birth</label>
                    <input class="inputField" type="date" name="dob">
                </div>

                <div class="row">
                    <label for="image">Profile Picture</label>
                    <input type="file" name="image" id="">
                </div>

                <div class="row">
                    <label for="password">Password</label>
                    <input class="inputField" type="password" name="password" placeholder="Enter Your Password">
                </div>
            </div>

            <div class="anchor">
                <a href="home.php">Back To Home</a>
            </div>

            <input type="submit" name="submit" value="SUBMIT">

        </form>
    </div>


    <?php
    if(isset($_POST['submit'])){
        $fullname = $_POST['fullname'];
        $mobile   = $_POST['mobile'];
        $email    = $_POST['email'];
        $gender = implode(", ", $_POST['gender']);
        $dob      = $_POST['dob'];
        $password = $_POST['password'];

        if(isset($_FILES['image'])){
            $imgName     = $_FILES['image']['name'];
            $imgSize     = $_FILES['image']['size']; 
            $imgTempName = $_FILES['image']['tmp_name'];
            $imgType     = $_FILES['image']['type'];

            move_uploaded_file($imgTempName,"uploadedImages/".$imgName);
        }

        $query = "INSERT INTO user_tbl (fullname, mobile, email, gender, dob, pp, password) VALUES ('$fullname', '$mobile', '$email', '$gender', '$dob', '$imgName', '$password')";
        $result = mysqli_query($conn,$query);

        unset($_SESSION["username"]);
        unset($_SESSION["password"]);
        
        header('location:home.php');
    }
?>




    <script>
    function validateForm() {
        var fullname = document.forms["myForm"]["fullname"].value;
        var mobile = document.forms["myForm"]["mobile"].value;
        var email = document.forms["myForm"]["email"].value;
        var gender = document.forms["myForm"]["gender[]"].value;
        var dob = document.forms["myForm"]["dob"].value;
        var password = document.forms["myForm"]["password"].value;

        var fileInput = document.querySelector('input[type=file]');
        var file = fileInput.files[0];
        var fileSize = file.size / 1024 / 1024;
        var fileType = file.type.split('/')[1];

        if (fullname == "") {
            alert("Please enter your name.");
            return false;
        }
        if (mobile == "") {
            alert("Please enter your mobile number.");
            return false;
        }
        if (email == "") {
            alert("Please enter your email.");
            return false;
        }
        if (gender == "") {
            alert("Please select your gender.");
            return false;
        }
        if (dob == "") {
            alert("Please select your date of birth.");
            return false;
        }
        if (password == "") {
            alert("Please enter your password.");
            return false;
        }

        var mobileRegex = /^[0-9]{10}$/;
        if (!mobileRegex.test(mobile)) {
            alert("Please enter a valid 10-digit mobile number.");
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
            return;
        }

        if (fileInput.files.length > 0) {
            var file = fileInput.files[0];
            var fileSize = file.size / 1024 / 1024;
            var fileType = file.type.split('/')[1];

            if (fileSize > 10) {
                alert("File size should be less than 10MB.");
                return false;
            }

            if (fileType != "jpeg" && fileType != "jpg" && fileType != "png") {
                alert("Only JPEG, JPG, and PNG files are allowed.");
                return false;
            }
        }


        return true;
    }
    </script>
</body>

</html>