<head>
    <link rel="stylesheet" href="Unit6_process_order.css">
    <script src="Unit6_script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>

<header>
    <?php include 'Unit6_header.php'?>
</header>

<body>
    <?php include 'Unit6_database.php'; ?>

    <?php
        //gets customer info from DB
        $user_email = $_POST['email'];
        $exists = true; 
        $customer = findCustomerEmail($user_email);
        $order_time = $_POST['purchase']; 

        if($customer) {
            $first_name = $customer['first_name'];
            $last_name = $customer['last_name'];
        }
        else {
            $new_first_name = $_POST['first_name']; 
            $new_last_name = $_POST['last_name'];
            $exists = false; 
            addNewCustomer($new_first_name, $new_last_name, $user_email);
            $customer = findCustomerEmail($user_email); 
        }

        //gets the product info 
        $selectedCarID = $_POST['cars']; 
        $selectedCar = findProductID($selectedCarID);
        $quantity = $_POST['quantity']; 
        $price = $selectedCar['price'];
        $formatted_price = number_format($price, 2); 
        $subtotal = $price * $quantity; 
        $total = number_format((float)$selectedCar['price'] * $quantity, 2);

        //calculates price based on tax and donation 
        $tax = 0.0075; 
        $total_tax = $subtotal * $tax; 
        $formatted_total_tax = number_format($subtotal * $tax, 2);  
        $total_after_tax = $subtotal + $total_tax; 
        $formatted_total_after_tax = number_format((float)$total_after_tax, 2); 
        $donation_choice = $_POST['choice'];
        if($donation_choice === 'Yes') {
            $total_before_donation = $total_after_tax;   
            $total_after_tax = ceil((float)$total_after_tax);
            $donation_amount = $total_after_tax - $total_before_donation; 
            $formatted_donation_amount = number_format($donation_amount, 2); 
            $total_with_donation = number_format($total_before_donation + $formatted_donation_amount, 2); 
        }
        else {
            $donation_amount = 0.00; 
        }
    ?>

    <section id="receipt">
        <?php if($exists): ?>
            <p><strong>Hello <?= $first_name . " " . $last_name ?> - </strong><i>Welcome back!</i></p>
        <?php else: ?>
            <p><strong>Hello <?= $new_first_name . " " . $new_last_name ?> - </strong><i>Welcome! Thank you for tyring out Dream Car!</i></p>
        <?php endif; ?>
        <p>We hope you enjoy driving your new <strong><i><?= $selectedCar['product_name'] ?></i></strong>!</p>
        <p>Order details:</p>
        <p id="order"><?= $quantity ?> @ $<?= $formatted_price ?>:  $<?= $total ?></p>
        <p id="order">Tax:  $<?= $formatted_total_tax ?></p>
        <p id="order">Subtotal:  $<?= $formatted_total_after_tax ?></p>
        <?php if($donation_choice === 'Yes'): ?>
            <p id="order">Total with donation:  $<?= $total_with_donation ?></p>
        <?php endif; ?>
        <?= addOrder($selectedCarID, $customer['id'], $quantity, $total_after_tax, $tax, $donation_amount, $order_time) ?>
        <?= sellProduct($selectedCar['product_name'], $quantity); ?>
        <br>
        <p>We'll send new cars and special offers to <?= $user_email ?></p>
        <p class="deals">Based on your viewing history, we'd like to offer 20% off these items:</p>
        <ul id="viewed_products" class="deals">
        </ul>
    </section>
    <footer>
        <?php include 'Unit6_footer.php'?>
    </footer>
    <script>
        printViewingHistory("<?php echo $selectedCar['product_name']; ?>"); 
    </script>
</body>