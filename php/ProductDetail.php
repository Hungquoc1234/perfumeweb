<?php
    if(!isset($_COOKIE['userid'])){
        header('Location: Login.php');
        die();
    }

    $admin = '';
    if($_COOKIE['role'] == 'admin'){
        $admin = 'Admin';
    }

    session_start();

    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
    }

    if(isset($_POST['submit'])){
        $id = $_GET['product-id'];
        $quantity = (int)$_POST['quantity'];

        $product = [$id, $quantity];

        if(isset($_SESSION['cart'])){
            $alreadyInCart = $_SESSION['cart'];
            $isAlreadyInCart = false;

            for($i = 0; $i < count($alreadyInCart); $i++){
                if($alreadyInCart[$i][0] == $id){
                    $isAlreadyInCart = true;
                    $alreadyInCart[$i][1] += $quantity;
                    break;
                }
            }
            
            if($isAlreadyInCart == false){
                $alreadyInCart[] = $product;
            }
             
            $_SESSION['cart'] = $alreadyInCart;
        } else{
            $_SESSION['cart'][] = $product;
        }

    }

    $cart = [];
    if(isset($_SESSION['cart'])){
        $cart = $_SESSION['cart'];
    }

    $productQuantity = 0;
    for($i = 0; $i < count($cart); $i++){
        $productQuantity += $cart[$i][1];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="..\css\ProductDetail.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="head">
        <div class="logo">
            <img src="..\img\shiba.jpg" alt="" class="logo-img">
            <span class="brand-name">My Brand</span>
        </div>

        <div class="search">
            <i class="fa-solid fa-magnifying-glass magnifying-glass"></i>
            <input type="text" class="search-bar" placeholder="Search">
            <i class="fa-solid fa-filter filter"></i>
        </div>

        <div class="notification-and-avatar">

            <i class="fa-sharp fa-solid fa-bell notification"></i>


            <i class="fa-sharp fa-solid fa-user avatar"></i>
        </div>
    </div>
    
    <div class="sidebar-and-body">
        <div class="sidebar">
            <ul class="menu">
                <li class="menu-item first">
                    <a href="HomePage<?php echo $admin;?>.php" class="menu-button">
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
                            if($productQuantity > 0){
                                echo '<div class="quantity-container"><span>'.$productQuantity.'</span></div>';
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
        </div>

        <?php
            if(isset($_GET['product-id'])){
                $id = $_GET['product-id'];

                $con = mysqli_connect('localhost', 'root', '', 'customers');
                if(!$con){
                    die("Connection failed! ".mysqli_connect_error());
                }

                $result = mysqli_query($con, "select * from product where id = '$id'");
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_assoc($result);
                    echo '
                    <div class="body">
                        <div class="image-and-basic-information">
                            <div class="basic-info">
                                <h1 class="product-name">'.$row['name'].'</h1>
                                <div class="product-price">'.number_format($row['price'], 0, '', '.').'đ</div>

                                <form method="post">
                                    <div class="adjust-quantity-container">
                                        <span class="minus">-</span>
                                        <input class="quantity" type="number" name="quantity" min="1" value="1">
                                        <span class="add">+</span>
                                    </div>
                                    <div class="buy-and-add-cart">
                                        <a href="" class="buy-button"><span>Buy</span></a>
                                        <button type="submit" name="submit" class="add-cart-button"><span>Add cart</span></button>
                                    </div>
                                </form> 
                            </div>

                            <img src="..\img\\'.$row['image'].'" class="product-image">
                        </div>

                        <div class="description-title-and-description">
                            <h2 class="description-title">Discription</h2>
                            <p class="description">'.$row['description'].'</p>
                        </div>
                    </div>  
                    ';
                }
            }
        ?>
    </div>

    <script>
        const body = document.querySelector('body'),
              toggle = document.querySelector('.toggle-container'),
              sidebar = document.querySelector('.sidebar'),
              bodyOfBody = document.querySelector('.body'),
              switchBtn = document.querySelector('.fa-solid.sun'),
              minus = document.querySelector('.minus'),
              add = document.querySelector('.add'),
              quantity = document.querySelector('.quantity');
        
        let a = 1;

        minus.addEventListener('click', function(e){
            if(a > 1){
                a--;
                console.log(a);
                quantity.value = a;
            }
        })

        add.addEventListener('click', function(e){
            a++;
            console.log(a);
            quantity.value = a;
        })

        toggle.addEventListener("click", function(e){
            sidebar.classList.toggle('close');
            bodyOfBody.classList.toggle('expand');

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
        }

        load();
    </script>
</body>
</html>