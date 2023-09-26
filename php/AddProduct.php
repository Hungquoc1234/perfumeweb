<?php
    if(!isset($_COOKIE['userid']) || $_COOKIE['role'] != 'admin'){
        header('Location: Login.php');
        die();
    }

    $name = $supplier = $imageName = $imagePath = $price = $sex = $scent = $concertration = $description = '';

    $check = '';

    if(isset($_POST['name'])){
        $name = $_POST['name'];
        if(empty($name)){
            $check = 'Please enter at least product name!';
        }
    }
    if(isset($_POST['supplier'])){
        $supplier = $_POST['supplier'];
    }
    
    if(isset($_POST['price'])){
        $price = $_POST['price'];
    }
    if(isset($_POST['sex'])){
        $sex = $_POST['sex'];
    }
    if(isset($_POST['scent'])){
        $scent = $_POST['scent'];
    }
    if(isset($_POST['concertration'])){
        $concertration = $_POST['concertration'];
    }
    if(isset($_POST['description'])){
        $description = $_POST['description'];
    }

    if(!empty($_FILES['image']['name'])){
        $imageName = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imagePath = '..\img\\' . $imageName;

    }

    if(!empty($name)){
        $description = str_replace("'", "`", $description);

        $con = mysqli_connect('localhost', 'root', '', 'customers');
        if(!$con){
            die("Connection failed: ".mysqli_connect_error());
        }
    
        mysqli_query($con, "insert into product values(NULL, '$name', '$imageName', '$price', '$supplier', '$sex', '$scent', '$concertration', '$description')");
        
        mysqli_close($con);
    
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="..\css\AddEditProduct.css?v=<?php echo time(); ?>">
</head>
<body>
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
            <div class="container">
                <form method="post" enctype="multipart/form-data">
                    <label for="image">Image:</label>
                    <input type="file" name="image" onchange="uploadImage(event)"><br>
                    <img src="<?php echo $imagePath?>" id="uploadedImage"><br>

                    <label for="name">Name:</label>
                    <input type="text" name="name" placeholder="<?php echo $check;?>"><br>

                    <label for="price">Price:</label>
                    <input type="number" name="price" ><br>

                    <label for="supplier">Supplier:</label>
                    <input type="text" name="supplier" ><br>

                    <label for="sex">Sex:</label>
                    <select name="sex" id="sex">
                        <option value="" disabled selected hidden></option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="unisex">Unisex</option>
                    </select><br>

                    <label for="scent">Scent:</label>
                    <select name="scent" id="scent">
                        <option value="" disabled selected hidden></option>
                        <option value="floral">Floral</option>
                        <option value="citrust">Citrust</option>
                        <option value="green">Green</option>
                        <option value="aquatic">Aquatic</option>
                        <option value="woody">Woody</option>
                        <option value="fruity">Fruity</option>
                    </select><br>

                    <label for="concertration">Concertration:</label>
                    <select name="concertration" id="concertration">
                        <option value="" disabled selected hidden></option>
                        <option value="perfume">Perfume</option>
                        <option value="edp">EDP</option>
                        <option value="edt">EDT</option>
                        <option value="edc">EDC</option>
                    </select><br>   

                    <label for="description">Description:</label>
                    <textarea name="description"></textarea><br>
                    <div class="save-cancel-button">
                        <input type="submit" value="Save" class="save-button" onclick="storeToast()">
                        <a href="ProductsManaging.php" class="cancel-button"><span>Cancel</span></a>
                    </div>
                </form>
            </div>
        </div>

        <div class="toast">
            <i class="fa-solid fa-xmark" onclick="closeToast()"></i>
            <div class="content">
                <i class="fa-solid fa-check"></i>
                <span>Add successfully</span>
            </div>
            <div class="process"></div>
        </div>
    </div>

    <script>
        const body = document.querySelector('body')
            toggle = document.querySelector('.toggle-container'),
              sidebar = document.querySelector('.sidebar'),
              bodyOfBody = document.querySelector('.body'),
              switchBtn = document.querySelector('.fa-solid.sun'),
              orders = document.querySelector('.orders'),
              chat = document.querySelector('.chat'),
              last = document.querySelector('.last'),
              toast = document.querySelector('.toast'),
              toastProcess = document.querySelector('.process');

        function closeToast(){
            toast.classList.remove('active');
        }

        function storeToast(){
            localStorage.setItem('toastShown', 'active');
        }

        window.addEventListener('load', function(){
            if(localStorage.getItem('toastShown')){
                toast.classList.toggle('active');
                toastProcess.classList.toggle('active');
                setTimeout(function(){
                    toast.classList.remove('active');
                }, 5000);

                localStorage.removeItem('toastShown');
            }
        })

        function uploadImage(event) {
            const uploadedImage = document.getElementById('uploadedImage');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    uploadedImage.src = e.target.result;
                    uploadedImage.style.display = 'block';
                }

                reader.readAsDataURL(file);
            } else {
                uploadedImage.src = "#"; // Clear the preview if no file is selected
            }
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