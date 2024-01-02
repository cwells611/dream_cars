<?php date_default_timezone_set("America/Denver"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Caden Wells">
    <title>Dream Cars</title>
    <link rel="stylesheet" href="Unit6_store.css">
    <script src="Unit6_script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<body>
    <header id="store_header">
        <?php include 'Unit6_header.php';?>
    </header>
    <?php include 'Unit6_database.php';?>
    <form id="order_form" method="POST" action="Unit6_process_order.php">
    <section id="personal_info">
        <fieldset>
            <legend>Personal Info</legend>
            <label for="first_name">First Name:<p class="required">*</p></label>
            <input type="text" id="first_name" name="first_name"  pattern="^[A-Za-z' ]+$" oninvalid="this.setCustomValidity('Please math the requested format.\n Names can only include letters, spaces and apostrophe')" oninput="this.setCustomValidity('')" required><br><br>
            <label for="last_name">Last Name:<p class="required">*</p></label>
            <input type="text" id="last_name" name="last_name" pattern="^[A-Za-z' ]+$" oninvalid="this.setCustomValidity('Please math the requested format.\n Names can only include letters, spaces and apostrophe')" oninput="this.setCustomValidity('')" required><br><br>
            <label for="email">Email<p class="required">*</p></label>
            <input type="email" id="email" name="email" required><br>
        </fieldset>
    </section>
    <br>
    <section id="product_info">
        <fieldset>
            <legend>Product Info</legend>
            <select id="cars" name="cars" onchange="chooseImg(this)" required>
                <option value="">-- select a dream car --</option>
                <?php $products = getProducts(); ?>
                <?php if($products->num_rows > 0): ?>
                    <?php  while($product = $products->fetch_assoc()): ?>
                        <?php if($product['inactive'] == 0): ?>
                            <option value="<?= $product['id'] ?>" data-img-name="<?= $product['image_name'] ?>" data-in-stock="<?= $product['in_stock'] ?>" data-product-name="<?= $product['product_name'] ?>"><?= $product['product_name'] ?> - <?= number_format($product['price'], 2) ?></option>
                        <?php endif; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
            <br>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="1" min="1" max="100">
        </fieldset>
    </section>

    <section id="round_up">
        <p>Round up to the nearest dollar for a donation?</p>
        <input type="radio" id="yes" name="choice" value="Yes" checked="checked">
        <label for="yes">Yes</label><br>
        <input type="radio" id="no" name="choice" value="No">
        <label for="no">No</label><br>
    </section>
    <br>
    <button id="purchase" name="purchase" type="submit" value="<?php echo time(); ?>" onclick="getViewingHistory()">Purchase</button>
    </form>

    <aside id="image">
        <p id="no_image">Select a car to see the image</p>
        <img src="" id="product">
        <p id="stockP"></p>
    </aside>

    <footer id="store_footer">
        <?php include 'Unit6_footer.php';?>
    </footer>
</body>
</html>