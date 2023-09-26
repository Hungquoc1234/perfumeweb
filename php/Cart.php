<?php
    if(!isset($_COOKIE['userid'])){
        header('Location: Login.php');
    }

    $con = mysqli_connect('localhost', 'root', '', 'customers');
    if(!$con){
        die("Connection failed: ".mysqli_connect_error());
    }

    session_start();

    if(isset($_POST['id']) && isset($_POST['quantity'])) {
        for($i = 0; $i < count($_SESSION['cart']); $i++) {
            if($_POST['id'] == $_SESSION['cart'][$i][0]) {
                $_SESSION['cart'][$i][1] = $_POST['quantity'];
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
    <link rel="stylesheet" href="../css/Cart.css?v=<?php echo time(); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<nav class="head">
        <!-- logo -->
        <div class="logo">
            <img src="..\img\shiba.jpg" alt="" class="logo-img">
            <span class="brand-name">My Brand</span>
        </div>

        <!-- search -->
        <div class="search">
            <i class="fa-solid fa-magnifying-glass magnifying-glass"></i>
            <input type="text" class="search-bar" placeholder="Search">
            <i class="fa-solid fa-filter">
                <div class="dropdown">
                    <div class="category-container">Sex
                        <div class="line"></div>
                        <ul class="category-list">    
                            <li class="category">Male</li>
                            <li class="category">Female</li>
                            <li class="category">Unisex</li>
                        </ul>
                    </div>
                    
                    <div class="category-container">Scent
                    <div class="line"></div>
                        <ul class="category-list">
                            <li class="category">Floral</li>
                            <li class="category">Citrust</li>
                            <li class="category">Green</li>
                        </ul>
                        <ul class="category-list">
                            <li class="category">Aquatic</li>
                            <li class="category">Fruity</li>
                            <li class="category">Woody</li>
                        </ul>
                    </div>
                    
                    <div class="category-container">Other
                    <div class="line"></div>
                        <ul class="category-list">
                            <li class="category">Popular</li>
                            <li class="category">Discount</li>
                            <li class="category">Newest</li>
                        </ul>
                    </div>
                    
                    <div class="apply-container">
                        <div class="apply-button"><span class="apply-text">Apply</span></div>
                    </div>
                </div>
            </i>
        </div>

        <div class="notification-and-avatar">
            <!-- notification -->
            <i class="fa-sharp fa-solid fa-bell notification"></i>

            <!-- avatar -->
            <i class="fa-sharp fa-solid fa-user avatar"></i>
        </div>
    </nav>

    <div class="sidebar-and-body">
        <nav class="sidebar">
            <ul class="menu">
                <li class="menu-item first">
                    <a href="<?php 
                        if($_COOKIE['role'] == 'admin'){
                            echo 'HomePageAdmin.php';
                        } else{
                            echo 'HomePage.php';
                        }
                        ?>" class="menu-button">
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
                    <a href="" class="menu-button">
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
            <div class="container">
                <h3>Your cart</h3>
                
                <?php
                    if(isset($_SESSION['cart'])){
                        if(count($_SESSION['cart']) > 0){
                            $totalPrice = 0;
                            echo '
                                <table class="products-table">
                                    
                                        <tr>
                                            <th></th>
                                            <th>Name</th>   
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total price</th>
                                            <th></th>
                                        </tr>
                                ';
        
                            for($i = 0; $i < count($_SESSION['cart']); $i++){
                                $result = mysqli_query($con, 'select id, name, image, price from product where id = '.$_SESSION['cart'][$i][0].'');
                                
                                if(mysqli_num_rows($result) > 0){
                                    $row = mysqli_fetch_assoc($result);
                                    $totalPrice += $row['price'] * $_SESSION['cart'][$i][1];
                                    echo '
                                        <tr>
                                            <td class="image"><a href="ProductDetail.php?product-id='.$row['id'].'"><img src="..\img\\'.$row['image'].'"></a></td>
                                            <td class="name"><a href="ProductDetail.php?product-id='.$row['id'].'">'.$row['name'].'</a></td>
                                            <td class="price">'.number_format($row['price'], 0, '', '.').'đ</td>
                                            <td class="quantity">
                                                <div>
                                                    <div class="adjust-quantity-container">
                                                        <span class="minus" onclick="getID('.$_SESSION['cart'][$i][0].')">-</span>
                                                        <input class="number" type="number" name="quantity" min="1" value="'.$_SESSION['cart'][$i][1].'">
                                                        <span class="add" onclick="getID('.$_SESSION['cart'][$i][0].')">+</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="total-price">'.number_format($row['price'] * $_SESSION['cart'][$i][1], 0, '', '.').'đ</td>
                                            <td class="remove"><divton class="remove-button" onclick="removeProduct('.$row['id'].')"><i class="fa-solid fa-xmark"></i></div></td>
                                        </tr>
                                    ';
                                }
                            }
                            echo ' 
                                </table>
                            
                            
                                <div class="total-price-and-pay-container">
                                    <div>
                                        <span class="total-price1">Total price:</span>
                                        <span class="total-price2">'.number_format($totalPrice, 0, '', '.').'đ</span><br>
                                    </div>
                                    <a href="Pay.php" class="pay-button"><span>Order</span></a>
                                </div>
                                ';
                        } else{
                            echo '<div>Your cart is empty.</div>';
                        }
                        
                    } else{
                        echo '<div>Your cart is empty.</div>';
                    }
                ?>
            </div>
        </div>
    </div>

    <script>
        const body = document.querySelector('body'),
              toggle = document.querySelector('.toggle-container'),
              sidebar = document.querySelector('.sidebar'),
              bodyOfBody = document.querySelector('.body'),
              switchBtn = document.querySelector('.fa-solid.sun'),
              filter = document.querySelector('.fa-filter'),
              dropdown = document.querySelector('.dropdown'),
              categories = document.querySelectorAll('.category'),
              category = document.querySelector('.category'),
              minus = document.querySelector('.minus'),
              add = document.querySelector('.add'),
              minusButtons = document.querySelectorAll('.minus'),
              addButtons = document.querySelectorAll('.add');

        let ID;

        function getID(id){
            ID = id;
        }

        minusButtons.forEach(minus => {
            minus.addEventListener('click', function(e) {
                const quantityInput = e.target.parentElement.querySelector('.number');
                let a = parseInt(quantityInput.value);
                if (a > 1) {
                    a--;
                    console.log(a);
                    quantityInput.value = a;
                }

                console.log('changed');
                $.post('Cart.php', {
                    'id': ID,
                    'quantity': a
                }, function(data) {
                    console.log(data);
                    location.reload();
                });
            })
        });

        addButtons.forEach(add => {
            add.addEventListener('click', function(e) {
                const quantityInput = e.target.parentElement.querySelector('.number');
                let a = parseInt(quantityInput.value);
                a++;
                console.log(a);
                quantityInput.value = a;

                $.post('Cart.php', {
                    'id': ID,
                    'quantity': a
                }, function(data) {
                    console.log(data);
                    location.reload();
                });
            });
        });

        function removeProduct(id){
            $.post('RemoveProductCart.php', {
                'id': id
            }, function(data){
                console.log(data);
                location.reload();
            });
        }
    

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

        categories.forEach(category => {
            category.addEventListener('click', function(e){
                category.classList.toggle('active');
            })
        })
        
        filter.addEventListener("click", function(e){
            filter.classList.toggle('active');
        })

        dropdown.addEventListener("click", function(e){
            e.stopPropagation();
        })

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