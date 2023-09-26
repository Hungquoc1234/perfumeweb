<?php
    session_start();
    if(isset($_POST['id'])){
        $cart = $_SESSION['cart'];
        $id = $_POST['id'];
        echo $id;
        for($i = 0; $i < count($cart); $i++){
            if($cart[$i][0] == $id){
                echo true;
                array_splice($cart, $i, 1);
                break;
            }
        }
        $_SESSION['cart'] = $cart;
    } else{
        echo "khong co post";
    }
    var_dump($_SESSION['cart']);