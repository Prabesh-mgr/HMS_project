<?php
    include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Data</title>
    <link rel="stylesheet" href="./CSS/adduser.css">
</head>

<body>

    <?php
        $id = $_GET['updateid'];
        $query = "SELECT * FROM user_tbl WHERE id = $id";
        $result = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($result);

    ?>


    <div class="wrapper">
        <h1>Update User</h1>
        <form name="myForm" action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
            <div class="row">
                <label for="name">Fullname</label>
                <input class="inputField" type="text" name="fullname" value="<?php echo $row['fullname']; ?>" placeholder="Enter Your Fullname">
            </div>

            <div class="row">
                <label for="mobile">Mobile</label>
                <input class="inputField" type="tel" name="mobile" value="<?php echo $row['mobile']; ?>" placeholder="Enter Your Mobile Number">
            </div>

            <div class="row">
                <label for="email">Email</label>
                <input class="inputField" type="email" name="email" value="<?php echo $row['email']; ?>" placeholder="Enter Your Email">
            </div>


            <div class="row">
                <label for="gender">Gender</label>
                <input type="radio" name="gender[]" value="Male" <?php if($row['gender'] == 'Male') echo 'checked'; ?>>
                <span>Male</span>
                <input type="radio" name="gender[]" value="Female" <?php if($row['gender'] == 'Female') echo 'checked'; ?>>
                <span>Female</span>
                <input type="radio" name="gender[]" value="Others" <?php if($row['gender'] == 'Others') echo 'checked'; ?>>
                <span>Others</span>
            </div>

            <div class="row">
                <label for="dob">Date of Birth</label>
                <input class="inputField" type="date" value="<?php echo $row['dob']; ?>" name="dob">
            </div>

            <div class="row">
                <label for="image">Profile Picture</label>
                <input type="file" name="image" path="<?php echo $row['pp']; ?>" id="">
            </div>

            <div class="row">
                <label for="password">Password</label>
                <input class="inputField" type="password" name="password" value="<?php echo $row['password']; ?>" placeholder="Enter Your Password">
            </div>

            <input type="submit" name="submit" value="UPDATE">

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

        $query = "UPDATE user_tbl SET fullname='$fullname', mobile='$mobile', email='$email', gender='$gender', dob='$dob', pp='$imgName', password='$password' WHERE id='$id'";
        $result = mysqli_query($conn,$query);
        
        header('location:index.php');
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