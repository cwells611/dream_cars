<?php 
include 'Unit6_database.php'; 
$conn = getConnection(); 

$id = $_GET["id"]; 
$quantity = getProductQuantity($conn, $id); 
echo $quantity; 
?>