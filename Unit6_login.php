<?php
session_start();

include 'Unit6_database.php'; 
//make sure email and password have values 
if(!empty($_POST['email']) && !empty($_POST['password'])) {
    //get the role based on email and password
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = getUser($email, $password);

    if($user == null) {
        header("Location: Unit6_index.php? err=Invalid User"); 
    }

    if(empty($user)) {
        $_SESSION['role'] = -1;
    }
    else {
        $_SESSION['role'] = $user['role'];
        $_SESSION['first_name'] = $user['first_name'];
    }

    //redirect to page based on role 
    if($_SESSION['role'] == 1) {
        header("Location: Unit6_order_entry.php");
    }    
    if($_SESSION['role'] == 2) {
        header("Location: Unit6_adminProduct.php");
    }
}
else {
    header("Location: Unit6_index.php? err=Invalid User"); 
}


?>