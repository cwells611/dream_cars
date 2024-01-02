<?php
function getConnection()
{
    include 'Unit6_database_credentials.php';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //return the connection
    return $conn;
}

function getCustomers() {
    //get connection to database 
    $conn = getConnection();

    //select everything from the customer table 
    $customerSQL = "SELECT * FROM customer";
    $customerStmt = $conn->prepare($customerSQL);
    $customerStmt->execute();

    //return the result of the query
    return $customerStmt->get_result();
}

function findCustomerID($id) {
    $conn = getConnection();
    $customerSQL = "SELECT first_name, last_name FROM customer WHERE id = ?"; 
    $customerStmt = $conn->prepare($customerSQL);
    $customerStmt->bind_param("i", $id);
    $customerStmt->execute();

    return $customerStmt->get_result()->fetch_assoc();
}

function findCustomerEmail($email) {
    $conn = getConnection();
    $customerSQL = "SELECT id, first_name, last_name FROM customer WHERE email = ?";
    $customerStmt = $conn->prepare($customerSQL);
    $customerStmt->bind_param("s", $email);
    $customerStmt->execute();

    return $customerStmt->get_result()->fetch_assoc();
}

function addNewCustomer($fName, $lName, $email) {
    $conn = getConnection();
    $newCustomerSQL = "INSERT INTO customer (first_name, last_name, email) VALUES (?,?,?)"; 
    $newCustomerStmt = $conn->prepare($newCustomerSQL);
    $newCustomerStmt->bind_param("sss", $fName, $lName, $email);
    $newCustomerStmt->execute();
}

function getOrders() {
    $conn = getConnection();

    //select the orders 
    $orderSQL = "SELECT orders.timestamp, customer.first_name, customer.last_name, product.product_name, orders.price, orders.donation 
    FROM orders, customer, product WHERE orders.product_id = product.id AND orders.customer_id = customer.id";
    $orderStmt = $conn->prepare($orderSQL);
    $orderStmt->execute();

    //return the result 
    return $orderStmt->get_result();
}

function addOrder($productId, $customerId, $quantity, $price, $tax, $donation, $time) {
    $conn = getConnection();

    //check the DB to see if the time is already in the DB
    $timeCheckSQL = "SELECT timestamp FROM orders WHERE timestamp = ?"; 
    $timeCheckStmt = $conn->prepare($timeCheckSQL);
    $timeCheckStmt->bind_param("s", $time); 
    $timeCheckStmt->execute();
    $orderTime = $timeCheckStmt->get_result()->fetch_assoc();
    if($orderTime == null) {
        //update order table with order 
        $orderSQL = "INSERT INTO orders (product_id, customer_id, quantity, price, tax, donation, timestamp) 
        VALUES (?,?,?,?,?,?,?)";
        $orderStmt = $conn->prepare($orderSQL);
        $orderStmt->bind_param("iiiddds", $productId, $customerId, $quantity, $price, $tax, $donation, $time); 
        $orderStmt->execute();   
    }
    else {
        return; 
    }
}

function getProducts() {
    $conn = getConnection();

    //select the products 
    $productsSQL = "SELECT * FROM product";
    $productStmt = $conn->prepare($productsSQL);
    $productStmt->execute();

    //return the result 
    return $productStmt->get_result();
}

function findProductID($id) {
    $conn = getConnection();
    $productSQL = "SELECT product_name, price FROM product WHERE id = ?"; 
    $productStmt = $conn->prepare($productSQL);
    $productStmt->bind_param("i", $id);
    $productStmt->execute();

    return $productStmt->get_result()->fetch_assoc();
}

function getProductQuantity($conn, $id) {
    $quantitySQL = "SELECT in_stock FROM product WHERE id = ?"; 
    $productStmt = $conn->prepare($quantitySQL);
    $productStmt->bind_param("i", $id);
    $productStmt->execute();

    $result = $productStmt->get_result()->fetch_assoc();
    return (int)$result['in_stock']; 
}

function sellProduct($name, $quantity) {
    $conn = getConnection();

    $newQuantity = 0; 

    //get the original quantity 
    $originalQuantitySQL = "SELECT in_stock FROM product WHERE product_name = ?"; 
    $originalQuantityStmt = $conn->prepare($originalQuantitySQL);
    $originalQuantityStmt->bind_param("s", $name); 
    $originalQuantityStmt->execute();
    $originalQuantity = $originalQuantityStmt->get_result()->fetch_column();

    //if the original quantity is not 0, update the table
    if($originalQuantity != 0) {
        //update in_stock attribute of product 
        $sellSQL = "UPDATE product SET in_stock = in_stock - ? WHERE product_name = ?";
        $sellStmt = $conn->prepare($sellSQL);
        $sellStmt->bind_param("is", $quantity, $name); 
        $sellStmt->execute();

        //get the new quantity of the product 
        $newQuantitySQL = "SELECT in_stock FROM product WHERE product_name = ?";
        $newQuantityStmt = $conn->prepare($newQuantitySQL);
        $newQuantityStmt->bind_param("s", $name); 
        $newQuantityStmt->execute();
        $newQuantity = $newQuantityStmt->get_result()->fetch_column();

        //if the new quantity is less than 0, set the new quantity to be 0 and update table 
        if($newQuantity <= 0) {
            $quantitySQL = "UPDATE product SET in_stock = 0 WHERE product_name = ?"; 
            $quantityStmt = $conn->prepare($quantitySQL);
            $quantityStmt->bind_param("s", $name);
            $quantityStmt->execute();
        }
    }
}

function addProduct($car, $img, $price, $quantity, $inactive) {
    $conn = getConnection();

    $newProductSQL = "INSERT INTO product(product_name, image_name, price, in_stock, inactive)
    VALUES (?,?,?,?,?)";  
    $newProductStmt = $conn->prepare($newProductSQL);
    $newProductStmt->bind_param("ssiii", $car, $img, $price, $quantity, $inactive);
    $newProductStmt->execute();
}

function updateProduct($id, $car, $img, $price, $quantity, $inactive) {
    $conn = getConnection(); 

    $updateProductSQL = "UPDATE product SET product_name = ?, image_name = ?, price = ?, in_stock = ?, inactive = ? WHERE id = $id";
    $updateProductStmt = $conn->prepare($updateProductSQL);
    $updateProductStmt->bind_param("ssiii",$car, $img, $price, $quantity, $inactive);
    $updateProductStmt->execute();
}

function deleteProduct($id) {
    $conn = getConnection();

    $deleteProductSQL = "DELETE FROM product WHERE id = ?";
    $deleteProductStmt = $conn->prepare($deleteProductSQL);
    $deleteProductStmt->bind_param("i", $id);
    $deleteProductStmt->execute();
}

function createCarTable() {
    $products = getProducts(); 

    echo "<table id='admin_product_table'>";
    echo "<tr>";
    echo "<th>Car</th>";
    echo "<th>Image</th>";
    echo "<th>Price</th>";
    echo "<th>Quantity</th>";
    echo "<th>Inactive?</th>";
    echo "</tr>";
    if($products->num_rows > 0) {
        foreach($products as $product) {
            echo "<tr>";
            echo "<td style='display: none;'>" . $product['id'] . "</td>";
            echo "<td>" . $product['product_name'] . "</td>";
            echo "<td>" . $product['image_name'] . "</td>";
            echo "<td>" . $product['price'] . "</td>";
            echo "<td>" . $product['in_stock'] . "</td>";
            if($product['inactive'] == 1) {
                echo "<td>Yes</td>";
            }
            else {
                echo "<td></td>";
            }
            echo "</tr>";
        }
    }
    echo "</table>";
}

function getUser($email, $password) {
    $conn = getConnection();
    $userSQL = "SELECT * FROM users WHERE email = ? AND password = ?"; 
    $userStmt = $conn->prepare($userSQL);
    $userStmt->bind_param("ss", $email, $password);
    $userStmt->execute();
    return $userStmt->get_result()->fetch_assoc();
}
?>