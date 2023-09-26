<?php
    if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['phonenumber']) && isset($_POST['password']) && isset($_POST['cpassword'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        
        //kiem tra thong tin co bi nhap thieu khong
        if(empty($username) || empty($email) || empty($phonenumber) || empty($password) || empty($cpassword)){
            //thong bao yeu cau nhap day du thong tin
            echo '<span class="alert not-enough-information">Please enter all information!</span>';
        }
        else{
            //kiem tra password va cpassword co khop voi nhau khong
            if($password != $cpassword){
                //thong bao password khong khop voi nhau
                echo '<span class="alert mismatched-password">Password does not match!</span>';
            }
            else{
            //ket noi voi database
            $con = mysqli_connect('localhost', 'root', '', 'customers');
            //kiem tra co ket noi duoc voi database khong
            if(!$con){
                die("Connection failed:".mysqli_connect_error());
            }
            
            // kiem tra username da ton tai chua
            $result = mysqli_query($con, "select name from user where name = '$username'");
            if(mysqli_num_rows($result) > 0){
                //thong bao username da ton tai
                echo '<span class="alert existed-username">This Username has already existed.</span>';
            }

            //kiem tra email da ton tai chua
            $result2 = mysqli_query($con, "select email from user where email = '$email'");
            if(mysqli_num_rows($result2) > 0){
                //thong bao email da ton tai
                echo '<span class="alert existed-email">This Email has already existed.</span>';
            }
            else{
                //them du lieu vao database
                mysqli_query($con, "insert into user values('', '$username', '$email', '$phonenumber', '', '$password', 'user')");

                mysqli_close($con);

                //chuyen sang trang Login.php
                header('Location: Login.php');
                
                die();
            }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="..\css\SignUp.css?v=<?php echo time(); ?>">
</head>
<body>
    <h1><center>Sign Up</center></h1>
    <form action="SignUp.php" method="post">
        <i class="fa-solid fa-user"></i>
        <input type="text" placeholder="Username" name="username"><br>
        <i class="fa-solid fa-envelope"></i>
        <input type="email" placeholder="Email" name="email"><br>
        <i class="fa-solid fa-phone"></i>
        <input type="text" placeholder="Phone Number" name="phonenumber"><br>
        <i class="fa-solid fa-lock"></i>
        <input type="password" placeholder="Password" name="password"><br>
        <input type="password" placeholder="Confirm Password" name="cpassword"><br>
        <input class="submit-button" type="submit" value="Sign Up"><br>
        <span><center>Already have account? <a href="Login.php">Login</a></center></span>
    </form>
</body>
</html>