<?php 
date_default_timezone_set("America/Denver"); 
session_start();
?>
<head>
    <link rel="stylesheet" href="Unit6_admin.css">
</head>

<body>
    <header>
        <?php 
        include('Unit6_header.php'); 
        if($_SESSION['role'] == -1) {
            header("Location: Unit6_index.php? err=Must log in first!"); 
        }
        ?>
    </header>
    <?php include('Unit6_database.php'); ?>
    <section id="customer_info">
        <p><strong>Customers</strong></p>
        <table>
            <tr>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Email</th>
            </tr>
        <?php $customers = getCustomers(); ?>
        <?php if($customers->num_rows > 0): ?>
            <?php while($customer = $customers->fetch_assoc()): ?>
            <tr>
                <td><?= $customer['last_name']; ?></td>
                <td><?= $customer['first_name']; ?></td>
                <td><?= $customer['email']; ?></td>
            </tr>
            <?php endwhile; ?>
        <?php endif; ?>
        </table>
    </section>

    <section id="orders">
        <p><strong>Orders</strong></p>
        <?php $orders = getOrders(); ?>
        <?php if($orders->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Car</th>
                    <th>Price</th>
                    <th>Donation Amount</th>
                </tr>
                <?php while($order = $orders->fetch_assoc()): ?>
                <tr>
                    <td><?= date("m/d/y h:i A", $order['timestamp']) ?></td>
                    <td><?= $order['first_name'] . ' ' . $order['last_name'] ?></td>
                    <td><?= $order['product_name'] ?></td>
                    <td><?= $order['price'] ?></td>
                    <td><?= $order['donation'] ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p id="no_orders">No Orders Yet!</p>
        <?php endif; ?>
    </section>

    <section id="cars">
        <p><strong>Cars</strong></p>
        <table>
            <tr>
                <th>Car</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        <?php $cars = getProducts(); ?>
        <?php if($cars->num_rows > 0): ?>
            <?php while($car = $cars->fetch_assoc()): ?>
            <tr>
                <td><?= $car['product_name']; ?></td>
                <td><?= $car['in_stock']; ?></td>
                <td><?= $car['price']; ?></td>
            </tr>
            <?php endwhile; ?>
        <?php endif; ?>
        </table>
    </section>

    <footer>
        <?php include('Unit6_footer.php'); ?>
    </footer>

</body>