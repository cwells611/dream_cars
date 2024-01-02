<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Caden Wells">
    <title>Dream Cars</title>
    <link rel="stylesheet" href="Unit6_adminProduct.css">
    <script src="Unit6_script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<body>
    <header id="product_header">
        <?php 
        include 'Unit6_header.php';
        if($_SESSION['role'] == -1) {
            header("Location: Unit6_index.php? err=Must log in first!"); 
        }
        if($_SESSION['role'] == 1) {
            header("Location: Unit6_index.php? err=You are not authorized for that page!"); 
        }
        ?>
    </header>
    <?php include 'Unit6_database.php';?>
    <main id="product_display_and_add" class="grid-container">
        <section id="product_list" class="column1">
            <h3>Cars</h3>
            <span id="products_table" onclick="populateProduct()"><?php createCarTable() ?></span>
        </section>
        <section id="new_product_info" class="column2">
            <form id="add_product">
                <fieldset>
                    <legend>Car Info</legend>
                    <p id="no_name" class="invalid"><strong>Car Make/Model can't be blank</strong></p>
                    <p id="no_img" class="invalid"><strong>Car Image can't be blank</strong></p>
                    <p id="no_price" class="invalid"><strong>Price can't be blank</strong></p>
                    <label for="car_name">Car Make/Model:<p class="required">*</p></label>
                    <input type="text" id="car_name" name="car_name"><br><br>
                    <label for="img_name">Car Image:<p class="required">*</p></label>
                    <input type="text" id="img_name" name="img_name"><br><br>
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="" min="1" max="100"><br><br>
                    <label for="price">Price:<p class="required">*</p></label>
                    <input type="number" id="price" name="price" value = "" step="0.01" min="0"><br><br>
                    <label for="inactive">Make Inactive</label>
                    <input type="checkbox" id="inactive" name="inactive" onchange="updateValue()">
                    <input type="hidden" id="inactiveValue" name="inactiveValue" value="0">
                    <input type="hidden" id="product_id" name="product_id" value=""> 
                </fieldset>
            </form>
            <button id="add" name="add" class="crud" type="submit" onclick="checkValid(this)">Add Car</button>
            <button id="update" name="update" class="crud" type="submit" onclick="checkValid(this)">Update</button>
            <button id="delete" name="delete" class="crud" type="submit" onclick="checkValid(this)">Delete</button>
        </section>
    </main>
    <footer id="product_footer">
        <?php include 'Unit6_footer.php';?>
    </footer>
</body>
</html>