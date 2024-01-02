<?php
include 'Unit6_database.php'; 

$email = $_POST['email'];
$prodID = $_POST['prodID'];
$order_time = $_POST['time'];
$quantity = $_POST['quantity'];
$exists = true; 

$customer = findCustomerEmail($email); 
if($customer) {
    $first_name = $customer['first_name'];
    $last_name = $customer['last_name'];
}
else {
    $new_first_name = $_POST['first_name']; 
    $new_last_name = $_POST['last_name'];
    $exists = false; 
    addNewCustomer($new_first_name, $new_last_name, $user_email);
    $customer = findCustomerEmail($email); 
}

$selectedCar = findProductID($prodID);
$price = $selectedCar['price'];
$formatted_price = number_format($price, 2); 
$subtotal = $price * $quantity; 
$total = number_format((float)$selectedCar['price'] * $quantity, 2);
$tax = 0.0075; 
$total_tax = $subtotal * $tax; 
$donation = 0.00; 
$formatted_total_tax = number_format($subtotal * $tax, 2);  
$total_after_tax = $subtotal + $total_tax; 
$formatted_total_after_tax = number_format((float)$total_after_tax, 2); 

addOrder($prodID, $customer['id'], $quantity, $price, $tax, $donation, $order_time); 
sellProduct($selectedCar['product_name'], $quantity); 

echo "Order submitted for: " . $first_name . " " . $last_name . " " . $quantity . " " . $selectedCar['product_name'] . " " . "Total $" . $formatted_total_after_tax;
?>