<?php
    if(isset($_POST['id'])){
        $con = mysqli_connect('localhost', 'root', '', 'customers');
        if(!$con){
            die("Connection failed: ".mysqli_connect_error());
        }

        $id = $_POST['id'];

        mysqli_query($con, "delete from product where id = '$id'");
        
        mysqli_close($con);
    }
    
?>