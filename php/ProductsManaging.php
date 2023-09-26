<?php
    if(!isset($_COOKIE['userid']) or $_COOKIE['role'] != "admin"){
        header('Location: Login.php');              
        die();
    }

    $con = mysqli_connect('localhost', 'root', '', 'customers');
    if(!$con){
        die("Connection failed: ".mysqli_connect_error());
    }

    if(isset($_POST['searchKeyword']) and !empty($_POST['searchKeyword'])){
        $searchKeyword = $_POST['searchKeyword'];
        mysqli_close($con);
        header("Location: ProductsManagingSearch.php?keyword=$searchKeyword");
        die();
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="..\css\ProductsManaging.css?v=<?php echo time(); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>
    <div class="head">
        <!-- logo -->
        <div class="logo">
            <img src="..\img\shiba.jpg" alt="" class="logo-img">
            <span class="brand-name">My Brand</span>
        </div>

        <!-- search -->
        <div class="search">
            <form method="post" class="search-form">
                <button type="submit" class="search-button"><i class="fa-solid fa-magnifying-glass magnifying-glass"></i></button>
                <input type="text" class="search-bar" placeholder="Search" name="searchKeyword">
            </form>
            <i class="fa-solid fa-filter">
                <form method="post" class="dropdown">
                    <div class="category-container">Sex
                        <div class="line"></div>
                        <div class="category-list">    
                            <input type="radio" name="sex-category" id="male" value="male">
                            <label for="male" class="category">Male</label><br>
                            <input type="radio" name="sex-category" id="female" value="female">
                            <label for="female" class="category">Female</label><br>
                            <input type="radio" name="sex-category" id="unisex" value="unisex">
                            <label for="unisex" class="category">Unisex</label><br>
                        </div>
                    </div>
                    
                    <div class="category-container">Scent
                    <div class="line"></div>
                        <div class="category-list">
                            <input type="radio" name="scent-category" id="floral" value="floral">
                            <label for="floral" class="category">Floral</label><br>
                            <input type="radio" name="scent-category" id="citrust" value="citrus">
                            <label for="citrust" class="category">Citrust</label><br>
                            <input type="radio" name="scent-category" id="green" value="green">
                            <label for="green" class="category">Green</label><br>
                        </div>
                        <div class="category-list">
                            <input type="radio" name="scent-category" id="aquatic" value="aquatic">
                            <label for="aquatic" class="category">Aquatic</label><br>
                            <input type="radio" name="scent-category" id="fruity" value="fruity">
                            <label for="fruity" class="category">Fruity</label><br>
                            <input type="radio" name="scent-category" id="woody" value="woody">
                            <label for="woody" class="category">Woody</label><br>
                        </div>
                    </div>
                    
                    <div class="category-container">Other
                    <div class="line"></div>
                        <div class="category-list">
                            <input type="radio" name="other-category" id="popular">
                            <label for="popular" class="category">Popular</label><br>
                            <input type="radio" name="other-category" id="discount">
                            <label for="discount" class="category">Discount</label><br>
                            <input type="radio" name="other-category" id="newest">
                            <label for="newest" class="category">Newest</label><br>
                        </div>
                    </div>
                    
                    <div class="apply-container">
                        <button type="submit" class="apply-button"><span class="apply-text">Apply</span></button>
                    </div>
                </form>
            </i>
        </div>

        <div class="notification-and-avatar">
            <!-- notification -->
            <i class="fa-sharp fa-solid fa-bell notification"></i>

            <!-- avatar -->
            <i class="fa-sharp fa-solid fa-user avatar"></i>
        </div>
    </div>

    <div class="sidebar-and-body">
        <div class="sidebar">
            <ul class="menu">
                <li class="menu-item first">
                    <a href="" class="menu-button">
                        <i class="fa-solid fa-spray-can-sparkles menu-icon"></i>
                        <span class="menu-name">Products</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="" class="menu-button">
                        <i class="fa-solid fa-users menu-icon"></i>
                        <span class="menu-name">Users</span>
                    </a>
                </li>
                <li class="menu-item orders">
                    <div class="menu-button">
                        <i class="fa-solid fa-truck-fast menu-icon"></i>
                        <span class="menu-name">Orders</span>
                    </div>
                    <ul class="orders-dropdown">
                        <li class="orders-status"><span class="status-name">Confirming</span></li>
                        <li class="orders-status"><span class="status-name">Delivering</span></li>
                        <li class="orders-status"><span class="status-name">Delivered</span></li>
                        <li class="orders-status"><span class="status-name">Canceled</span></li>
                    </ul>
                </li>
                <li class="menu-item chat">
                    <a href="" class="menu-button">
                        <i class="fa-solid fa-comment menu-icon"></i>
                        <span class="menu-name">Chat</span>
                    </a>
                </li>
                <li class="menu-item last">
                    <a href="HomePageAdmin.php" class="menu-button">
                        <i class="fa-solid fa-house menu-icon"></i>
                        <span class="menu-name">Home</span> 
                    </a>
                </li>
                <li class="menu-item"> 
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


        <div class="body">
            <div class="table-container">
                <div class="add-button-container"><a href="AddProduct.php" class="add-button"><span>Add</span></a></div>
                <table>
                    <tr>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Supplier</th>
                        <th>Sex</th>
                        <th>Scent</th>
                        <th>Concertration</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                    <?php
                        $pageNumber = $currentPage = '';

                        if(isset($_POST['sex-category'])){
                            $sex = $_POST['sex-category'];

                            $result2 = mysqli_query($con, "select * from product where sex = '$sex'");

                            $productNumber = mysqli_num_rows($result2);

                            $pageNumber = ceil($productNumber / 5);

                            $currentPage = 1;
                            if(isset($_GET['page'])){
                                $currentPage = $_GET['page'];
                            }

                            $b = ($currentPage - 1) * 5;
                            $result = mysqli_query($con, "select * from product where sex = '$sex' limit $b, 5 ");
                            while($row = mysqli_fetch_array($result)){
                                echo '
                                    <tr>
                                        <td class="image"><img src="..\img\\'.$row['image'].'" class="product-image"></td>
                                        <td class="id">'.$row['id'].'</td>
                                        <td class="name">'.$row['name'].'</td>
                                        <td class="price">'.$row['price'].'</td>
                                        <td class="supplier">'.$row['supplier'].'</td>
                                        <td class="sex">'.$row['sex'].'</td>
                                        <td class="scent">'.$row['scent'].'</td>
                                        <td class="concertration">'.$row['concertration'].'</td>
                                        <td class="description">'.$row['description'].'</td>
                                        <td class="delete-edit">
                                            <div>
                                                <a href="EditProduct.php?id='.$row['id'].'" class="edit-product-button"><span>Edit</span></a>
                                                <div class="delete-product-button" onclick="showConfirm('.$row['id'].')"><span>Delete</span></div>
                                            </div>
                                        </td>
                                    </tr>';
                            }
                        } else if(isset($_POST['scent-category'])){
                            $scent = $_POST['scent-category'];

                            $result2 = mysqli_query($con, "select * from product where scent = '$scent'");

                            $productNumber = mysqli_num_rows($result2);

                            $pageNumber = ceil($productNumber / 5);

                            $currentPage = 1;
                            if(isset($_GET['page'])){
                                $currentPage = $_GET['page'];
                            }

                            $b = ($currentPage - 1) * 5;
                            $result = mysqli_query($con, "select * from product where scent = '$scent' limit $b, 5 ");
                            while($row = mysqli_fetch_array($result)){
                                echo '
                                    <tr>
                                        <td class="image"><img src="..\img\\'.$row['image'].'" class="product-image"></td>
                                        <td class="id">'.$row['id'].'</td>
                                        <td class="name">'.$row['name'].'</td>
                                        <td class="price">'.$row['price'].'</td>
                                        <td class="supplier">'.$row['supplier'].'</td>
                                        <td class="sex">'.$row['sex'].'</td>
                                        <td class="scent">'.$row['scent'].'</td>
                                        <td class="concertration">'.$row['concertration'].'</td>
                                        <td class="description">'.$row['description'].'</td>
                                        <td class="delete-edit">
                                            <div>
                                                <a href="EditProduct.php?id='.$row['id'].'" class="edit-product-button"><span>Edit</span></a>
                                                <div class="delete-product-button" onclick="showConfirm('.$row['id'].')"><span>Delete</span></div>
                                            </div>
                                        </td>
                                    </tr>';
                            }
                        }
                        else if(isset($_POST['sex-category']) and isset($_POST['scent-category'])){
                            $sex = $_POST['sex-category'];
                            $scent = $_POST['scent-category'];

                            $result2 = mysqli_query($con, "select * from product where sex = '$sex' and scent = '$scent'");

                            $productNumber = mysqli_num_rows($result2);

                            $pageNumber = ceil($productNumber / 5);

                            $currentPage = 1;
                            if(isset($_GET['page'])){
                                $currentPage = $_GET['page'];
                            }

                            $b = ($currentPage - 1) * 5;
                            $result = mysqli_query($con, "select * from product where sex = '$sex' and scent = '$scent' limit $b, 5 ");
                            while($row = mysqli_fetch_array($result)){
                                echo '
                                    <tr>
                                        <td class="image"><img src="..\img\\'.$row['image'].'" class="product-image"></td>
                                        <td class="id">'.$row['id'].'</td>
                                        <td class="name">'.$row['name'].'</td>
                                        <td class="price">'.$row['price'].'</td>
                                        <td class="supplier">'.$row['supplier'].'</td>
                                        <td class="sex">'.$row['sex'].'</td>
                                        <td class="scent">'.$row['scent'].'</td>
                                        <td class="concertration">'.$row['concertration'].'</td>
                                        <td class="description">'.$row['description'].'</td>
                                        <td class="delete-edit">
                                            <div>
                                                <a href="EditProduct.php?id='.$row['id'].'" class="edit-product-button"><span>Edit</span></a>
                                                <div class="delete-product-button" onclick="showConfirm('.$row['id'].')"><span>Delete</span></div>
                                            </div>
                                        </td>
                                    </tr>';
                            }
                        } else{
                            $result2 = mysqli_query($con, "select * from product");

                            $productNumber = mysqli_num_rows($result2);

                            $pageNumber = ceil($productNumber / 5);

                            $currentPage = 1;
                            if(isset($_GET['page'])){
                                $currentPage = $_GET['page'];
                            }

                            $b = ($currentPage - 1) * 5;
                            $result = mysqli_query($con, 'select * from product limit '.$b.', 5 ');
                            while($row = mysqli_fetch_array($result)){
                                echo '
                                    <tr>
                                        <td class="image"><img src="..\img\\'.$row['image'].'" class="product-image"></td>
                                        <td class="id">'.$row['id'].'</td>
                                        <td class="name">'.$row['name'].'</td>
                                        <td class="price">'.$row['price'].'</td>
                                        <td class="supplier">'.$row['supplier'].'</td>
                                        <td class="sex">'.$row['sex'].'</td>
                                        <td class="scent">'.$row['scent'].'</td>
                                        <td class="concertration">'.$row['concertration'].'</td>
                                        <td class="description">'.$row['description'].'</td>
                                        <td class="delete-edit">
                                            <div>
                                                <a href="EditProduct.php?id='.$row['id'].'" class="edit-product-button"><span>Edit</span></a>
                                                <div class="delete-product-button" onclick="showConfirm('.$row['id'].')"><span>Delete</span></div>
                                            </div>
                                        </td>
                                    </tr>';
                            }
                        }
                        
                        mysqli_close($con);
                    ?>
                </table>

                <div class="pagination-container">
                    <?php

                        if($currentPage != 1){
                            echo '
                                <a href="?page=1" class="pre-button"><span>First</span></a>
                                <a href="?page='.($currentPage - 1).'" class="pre-button"><span>Pre</span></a>
                            ';
                        }

                        $start = max(1, $currentPage - floor(5 / 2));
                        $end = min($pageNumber, $start + 5 - 1);
                    
                        for($i = $start; $i <= $end; $i++){
                            if($i == $currentPage){
                                echo '<a href="?page='.$i.'" class="pagination-button active"><span>'.$i.'</span></a>';
                            } else{
                                echo '<a href="?page='.$i.'" class="pagination-button"><span>'.$i.'</span></a>';
                            }
                        }

                        if($currentPage != $pageNumber){
                            echo '
                                <a href="?page='.($currentPage + 1).'" class="next-button"><span>Next</span></a>
                                <a href="?page='.$pageNumber.'" class="pre-button"><span>Last</span></a>
                            ';
                        }
                    ?>
                    
                </div>
            </div>

            
        </div>
    </div>

    <div class="popup-container">
        <div class="popup">
            <div class="exclamation-container"><i class="fa-solid fa-exclamation"></i></div>
            <div id="head">Are you sure to delete?</div>
            <p>Product's data will be lost permanently, be sure about that!</p>
            <div class="sure-cancel-container">
                <button class="sure-button" onclick="sureConfirm(true)"><span>Sure</span></button>
                <button class="cancel-button" onclick="sureConfirm(false)"><span>Cancel</span></button>
            </div>
        </div>
    </div>

    <div class="toast">
        <i class="fa-solid fa-xmark" onclick="closeToast()"></i>
        <div class="content">
            <i class="fa-solid fa-check"></i>
            <span>Delete successfully</span>
        </div>
        <div class="process"></div>
    </div>

    <script>
        const body = document.querySelector('body'),
              toggle = document.querySelector('.toggle-container'),
              sidebar = document.querySelector('.sidebar'),
              bodyOfBody = document.querySelector('.body'),
              switchBtn = document.querySelector('.fa-solid.sun'),
              filter = document.querySelector('.fa-filter'),
              dropdown = document.querySelector('.dropdown'),
              orders = document.querySelector('.orders'),
              chat = document.querySelector('.chat'),
              searchBar = document.querySelector('.search-bar'),
              searchForm = document.querySelector('.search-form'),
              popupContainer = document.querySelector('.popup-container'),
              toast = document.querySelector('.toast'),
              toastProcess = document.querySelector('.process');

        function closeToast(){
            toast.classList.remove('active');
        }

        searchBar.addEventListener('keydown', function(e){
            if(e.keyCode == 13){
                searchForm.submit();
            }
        })

        let ID = 0;
        
        function showConfirm(id){
            popupContainer.classList.toggle('active');
            ID = id;
        }

        function sureConfirm(isConfirmed){
            if(isConfirmed == true){
                deleteButton(ID);
            } else{
                popupContainer.classList.remove('active');
            }
        }  

        window.addEventListener('load', function(e){
            if(localStorage.getItem('toastShown')){
                toast.classList.toggle('active');
                toastProcess.classList.toggle('active');
                setTimeout(function(){
                    toast.classList.remove('active');
                }, 5000);

                localStorage.removeItem('toastShown');
            }
        })

        function deleteButton(id){
            $.post('DeleteProduct.php', {
                'id': id
            }, function(data){
                console.log(data);
                localStorage.setItem('toastShown', 'active');
                location.reload();
            })
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

        orders.addEventListener('click', function(e){
            orders.classList.toggle('active');
            if(orders.classList.contains('active')){
                if(!sidebar.classList.contains('close')){
                    chat.style.transform = 'translateY(165px)';
                } else{
                    chat.style.transform = 'translateY(0)';
                }
            } else{
                chat.style.transform = 'translateY(0)';
            }
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

            storeToggle(sidebar.classList.contains('close'));
            storeBodyExpand(bodyOfBody.classList.contains('expand'));
            if(orders.classList.contains('active')){
                if(!sidebar.classList.contains('close')){
                    chat.style.transform = 'translateY(165px)';
                } else{
                    chat.style.transform = 'translateY(0)';
                }
            } else{
                chat.style.transform = 'translateY(0)';
            }

            setWidthBody();
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