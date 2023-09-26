<?php
    if(!isset($_COOKIE['userid']) or $_COOKIE['role'] != "admin"){
        header('Location: Login.php');              
        die();
    }

    $con = mysqli_connect('localhost', 'root', '', 'customers');
    if(!$con){
        die();
    }

    session_start();

    $note = '';

    if(isset($_POST['name']) and isset($_POST['email']) and isset($_POST['phonenumber']) and isset($_POST['address'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];
        $address = $_POST['address'];
        $note = $_POST['note'];

        if(empty($name) or empty($email) or empty($phonenumber) or empty($address)){
            echo '<span>Please enter all information</span>';
        } else{
            mysqli_query($con, "INSERT INTO `order` VALUES ('', '".$_COOKIE['userid']."', '$name', '$phonenumber', '$email', '', '', '$note', '$address')");

            $result1 = mysqli_query($con, 'select id from `order` order by id desc limit 1');
            if(mysqli_num_rows($result1) > 0){
                $row = mysqli_fetch_assoc($result1);

                for($i = 0; $i < count($_SESSION['cart']); $i++){
                    mysqli_query($con, 'insert into cart values('.$row['id'].', '.$_SESSION['cart'][$i][0].', '.$_SESSION['cart'][$i][1].')');
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
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="..\css\Pay.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="sidebar-and-body">
        <nav class="sidebar">
            <ul class="menu">
                <li class="menu-item first">
                    <a href="" class="menu-button">
                        <i class="fa-solid fa-house menu-icon"></i>
                        <span class="menu-name">Home</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="" class="menu-button">
                        <i class="fa-solid fa-heart menu-icon"></i>
                        <span class="menu-name">Favorite</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="Cart.php" class="menu-button">
                        <i class="fa-solid fa-cart-shopping menu-icon"></i>
                        <span class="menu-name">Cart</span>
                        <?php
                            if(isset($_SESSION['cart'])){
                                $cart = $_SESSION['cart'];
                        
                                $productQuantity = 0;
                                for($i = 0; $i < count($cart); $i++){
                                    $productQuantity += $cart[$i][1];
                                }
                                if($productQuantity > 0){
                                    echo '<div class="quantity-container"><span>'.$productQuantity.'</span></div>';
                                }
                            }   
                        ?>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="" class="menu-button">
                        <i class="fa-solid fa-comment menu-icon"></i>
                        <span class="menu-name">Chat</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="" class="menu-button">
                        <i class="fa-solid fa-gear menu-icon"></i>
                        <span class="menu-name">Setting</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="ProductsManaging.php" class="menu-button">
                        <i class="fa-solid fa-pen menu-icon"></i> 
                        <span class="menu-name">Admin</span> 
                    </a>
                </li>
                <li class="menu-item last">
                    <a href="Logout.php" class="menu-button">
                        <i class="fa-solid fa-right-from-bracket menu-icon"></i> 
                        <span class="menu-name">Logout</span> 
                    </a>
                </li>

                <div class="light-dark-theme">
                    <div class="switch">
                        <i class="fa-solid sun"></i>
                    </div>
                    <span class="theme-mode-name">Dark Theme</span>
                </div>
                
            </ul>

            <div class="toggle-container">
                <i class="fa-solid toggle fa-chevron-left"></i>
            </div>
        </nav>

        <div class="body">
            <div class="body1">
                <div class="body1-container">
                    <form method="post">
                        <h3 class="head1">Contact information</h3>
                        <input type="text" name="name" placeholder="Full name"><br>
                        <input type="text" name="email" placeholder="Email"><br>
                        <input type="number" name="phonenumber" placeholder="Phone number"><br>
                        <h3 class="head2">Address</h3>
                        <input type="text" name="address" placeholder="Address"><br>
                        <textarea name="note" placeholder="Note (optional)"></textarea><br>
                        <input type="submit" class="order-button">
                    </form>
                </div>
            </div>
            <div class="body2">
                <div class="body2-container1">
                    <?php
                        $totalPrice = 0;
                        if(isset($_SESSION['cart'])){
                            if(count($_SESSION['cart']) > 0){
                                $cart = $_SESSION['cart'];

                                for($i = 0; $i < count($cart); $i++){
                                    $result = mysqli_query($con, 'select name, price, image from product where id = '.$cart[$i][0].'');

                                    if(mysqli_num_rows($result) > 0){
                                        $row = mysqli_fetch_assoc($result);
                                        $totalPrice += $cart[$i][1] * $row['price'];
                                        echo '
                                            <div class="product">
                                                <img src="..\img\\'.$row['image'].'">
                                                <div class="name-quantity">
                                                    <div class="name">'.$row['name'].'</div>
                                                    <div class="quantity">Quantity: '.$cart[$i][1].'</div>
                                                </div>
                                                <div class="total-price"><span>'.number_format($cart[$i][1] * $row['price'], 0, '', '.').'đ</span></div>
                                            </div>
                                        ';
                                    }
                                }
                            }
                        }
                    ?>

                    <div class="body2-container2">
                        <?php
                            if($totalPrice > 0){
                                echo '
                                    <span class="total-price1">Total:</span>
                                    <span class="total-price2">'.number_format($totalPrice, 0, '', '.').'đ</span>
                                ';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const body = document.querySelector('body'),
              toggle = document.querySelector('.toggle-container'),
              sidebar = document.querySelector('.sidebar'),
              bodyOfBody = document.querySelector('.body'),
              switchBtn = document.querySelector('.fa-solid.sun');

        function setWidthBody() {
            if (sidebar.classList.contains('close')) {
                console.log('true');
                bodyOfBody.style.width = 'calc(100vw - 97.5px)';
                bodyOfBody.style.marginLeft = '97.5px';
            } else {
                console.log('false');
                bodyOfBody.style.width = 'calc(100vw - 220px)';
                bodyOfBody.style.marginLeft = '220px';
            }
        }

        toggle.addEventListener("click", function(e){
            sidebar.classList.toggle('close');
            bodyOfBody.classList.toggle('expand');

            setWidthBody();

            storeToggle(sidebar.classList.contains('close'));
            storeBodyExpand(bodyOfBody.classList.contains('expand'));
        })

        switchBtn.addEventListener("click", function(e){
            body.classList.toggle('dark-theme');
            switchBtn.classList.toggle('animated');

            storeDarkLightMode(body.classList.contains('dark-theme'));

            if(body.classList.contains('dark-theme')){
                switchBtn.classList.remove('sun');
                switchBtn.classList.toggle('fa-moon');
            } else{
                switchBtn.classList.remove('fa-moon');
                switchBtn.classList.toggle('sun');
            }

            setTimeout(function(e){
                switchBtn.classList.remove('animated');
            }, 300)
        })

        //luu lai che do sang toi va dieu huong sidebar
        function storeDarkLightMode(value){
            localStorage.setItem('darkmode', value);
        }

        function storeToggle(value){
            localStorage.setItem('close', value);
        }

        function storeBodyExpand(value)
        {
            localStorage.setItem('expand', value);
        }

        //dua vao che do sang toi va dieu huong sidebar da luu de tai web
        function load(){
            // tai nen toi sang
            if(!localStorage.getItem('darkmode')){
                storeDarkLightMode(false);
                switchBtn.classList.toggle('sun');
            } else if(localStorage.getItem('darkmode') == 'true'){
                body.classList.toggle('dark-theme');
                switchBtn.classList.toggle('fa-moon');
                switchBtn.classList.remove('sun');
            }

            // tai dieu huong
            if(!localStorage.getItem('close')){
                storeToggle(false);
            } else if(localStorage.getItem('close') == 'true'){
                sidebar.classList.toggle('close');
            }

            //tai bang mo rong
            if(!localStorage.getItem('expand')){
                storeBodyExpand(false);
            } else if(localStorage.getItem('expand') == 'true'){
                bodyOfBody.classList.toggle('expand');
            }

            setWidthBody();
        }

        load();

    </script>
</body>
</html>