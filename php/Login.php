<?php
    if(isset($_COOKIE['userid'])){
        if($_COOKIE['role'] == 'admin'){
            header('Location: HomePageAdmin.php');
        }
        else{
            header('Location: HomePage.php');
        }
        die();
    }
    if(isset($_POST['email']) && isset($_POST['password'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        //kiem tra thong tin co bi nhap thieu khong
        if(empty($email) || empty($password)){
            //thong bao yeu cau nhap day du thong tin
            echo '<span class="alert not-enough-information">Please enter all information!</span>';
        }
        else{
            $con = mysqli_connect('localhost', 'root', '', 'customers');
            if(!$con){
                die("Connection failed: ".mysqli_connect_error());  
            }

            //kiem tra thong tin da ton tai chua
            $result = mysqli_query($con, "select id, password, role from user where email = '$email'");
            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_assoc($result);

                //kiem tra password co dung khong
                if($password == $row['password']){
                    setcookie("userid", $row['id'], time() + 36000, "/");
                    setcookie("role", $row['role'], time() + 36000, "/");
                    if($row['role'] == 'admin'){
                        header('Location: HomePageAdmin.php');
                    }
                    else if($row['role'] == 'user'){
                        header('Location: HomePage.php');
                    }
                    mysqli_close($con);
                    
                    die();
                }
                else{
                    //thong bao tai khoan hoac password khong dung
                    echo '<span class="alert wrong-account-or-password">Wrong Email or Password!</span>';
                }
            }
            else{
                //thong bao tai khoan hoac password khong dung
                echo '<span class="alert wrong-account-or-password">Wrong Email or Password!</span>';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="..\css\Login.css?v=<?php echo time(); ?>">
</head>
<body>
    <h1><center>Login</center></h1>
    <form action="Login.php" method="post">
        <i class="fa-solid fa-envelope"></i>
        <input type="text" name="email" placeholder="Email"><br>
        <i class="fa-solid fa-lock"></i>
        <input type="password" name="password" placeholder="Password"><br>
        <input class="submit-button" type="submit" values="Login">
        <span><center>Don't have any account? <a href="SignUp.php">Sign up</a></center></span>
    </form>
</body>
</html>