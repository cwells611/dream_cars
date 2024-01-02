<?php 
include 'Unit6_database.php';

$product_name = $_POST['car'];
$image_name = $_POST['img'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];
$inactive = $_POST['inactive'];

addProduct($product_name, $image_name, $price, $quantity, $inactive);
createCarTable(); 

?>