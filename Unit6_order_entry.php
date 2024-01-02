<?php 
date_default_timezone_set("America/Denver"); 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Caden Wells">
    <title>Dream Cars</title>
    <link rel="stylesheet" href="Unit6_order_entry.css">
    <script src="Unit6_script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<body>
    <header id="store_header">
        <?php 
        include 'Unit6_header.php';
        if($_SESSION['role'] == -1) {
            header("Location: Unit6_index.php? err=Must log in first!"); 
        }
        ?>
    </header>
    <?php include 'Unit6_database.php';?>
    <div id="left">
    <form id="order_form" method="POST" action="Unit6_process_order.php">
    <section id="personal_info">
        <fieldset>
            <legend>Personal Info</legend>
            <label for="first_name">First Name:<p class="required">*</p></label>
            <input type="text" id="first_name" name="first_name" onkeyup="populateCustomer(this.value, 'first')"><br><br>
            <label for="last_name">Last Name:<p class="required">*</p></label>
            <input type="text" id="last_name" name="last_name" onkeyup="populateCustomer(this.value, 'last')"><br><br>
            <label for="email">Email<p class="required">*</p></label>
            <input type="email" id="email" name="email"><br>
        </fieldset>
    </section>
    <br>
    <section id="product_info">
        <fieldset>
            <legend>Product Info</legend>
            <select id="cars" name="cars" onchange="showAvailable(this)">
                <option value="">-- select a dream car --</option>
                <?php $products = getProducts(); ?>
                <?php if($products->num_rows > 0): ?>
                    <?php  while($product = $products->fetch_assoc()): ?>
                        <option value="<?= $product['id'] ?>" data-img-name="<?= $product['image_name'] ?>" data-in-stock="<?= $product['in_stock'] ?>"><?= $product['product_name'] ?> - <?= number_format($product['price'], 2) ?></option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
            <br>
            <label for="available">Available:</label>
            <input type="number" id="available" name="available" value="" readonly>
            <br>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="1" min="1" max="100">
        </fieldset>
    </section>
    <br>
    <button id="purchase_order" name="purchase_order" type="button" value="<?php echo time(); ?>" onclick="checkForm();">Purchase</button>
    <button id="clear" name="clear" type="reset">Clear All Fields</button>
    </form>
    </div>

    <div id="right">
        <p><i>Choose an existing customer:</i></p>
        <span id="customerTable"></span>
        <p id="orderForm"></p>
    </div>
    <footer id="store_footer">
        <?php include 'Unit6_footer.php';?>
    </footer>
</body>
</html>