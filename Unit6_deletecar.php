<?php 
include 'Unit6_database.php'; 

$id = (int)$_POST['product_id']; 
try {
    deleteProduct($id);
}
catch (Exception $e) {
    echo "<script>alert('Can\'t delete this product, there are existing orders');</script>"; 
}
createCarTable();
?>