<?php
    setcookie("userid", $row['userid'], time() - 3600, "/");
    setcookie("role", $row['role'], time() - 3600, "/");

    header('Location: Login.php');