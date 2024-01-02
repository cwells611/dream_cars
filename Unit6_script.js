const products = [];

function chooseImg(imgValue) {
    //functionality to display image in aside 
    const img = document.getElementById("product");
    const imgP = document.getElementById("no_image");
    const stockP = document.getElementById("stockP"); 
    if(imgP != null) {
        imgP.remove();
    }
    //gets the name of the image 
    const imgSrc = imgValue.options[imgValue.selectedIndex].getAttribute('data-img-name'); 
    //gets the in_stock attribute of the product 
    const imgStock = imgValue.options[imgValue.selectedIndex].getAttribute('data-in-stock'); 
    img.setAttribute('src', 'images/' + imgSrc);
    img.style.margin = "5px";
    img.setAttribute('width', '95%');
    //check the stock and update message accordinly 
    if(imgStock == 0) {
        img.setAttribute('height', '200px');
        stockP.innerHTML = "SOLD OUT";
        stockP.style.display = "block";
        stockP.style.color = "red";
    }
    else if(imgStock < 5) {
        img.setAttribute('height', '200px');
        stockP.innerHTML = "Only " + imgStock + " left!";
        stockP.style.display = "block";
        stockP.style.color = "red";
    }
    else {
        img.setAttribute('height', '290px');
        stockP.style.display = "none"; 
    }
    //functionality to set a cookie for each product the user views 
    var productName = imgValue.options[imgValue.selectedIndex].getAttribute('data-product-name');
    products.push(productName);
}

function populateCustomer(value, name) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        //make sure the input field is not empty 
        if(value != '') {
            customerTable = this.responseText; 
            document.getElementById("customerTable").innerHTML = customerTable; 
        }
        else {
            document.getElementById("customerTable").innerHTML = "";      
        }
        highlightRow();
    }
    xmlhttp.open("GET", `Unit6_get_customer_table.php?letter=${value}&name_type=${name}`); 
    xmlhttp.send(); 
}

function highlightRow() {
    var table = document.getElementById("admin_product_table");
    var cells = document.getElementsByTagName("td");

    for(var i = 0; i < cells.length; i++) {
        var cell = cells[i];
        cell.onclick = function() {
            var currentRow = this.parentNode; 
            currentRow.style.backgroundColor = "yellow"; 
            var currentRowCells = currentRow.getElementsByTagName("td");
            document.getElementById("first_name").value = currentRowCells[0].textContent;
            document.getElementById("last_name").value = currentRowCells[1].textContent;
            document.getElementById("email").value = currentRowCells[2].textContent; 
        }
    }
}

function checkForm() {
    $("#purchase_order").click(function(e) {
        e.preventDefault(); 
    });
    //gets the requied field values
    var fName = $("#first_name").val(); 
    var lName = $("#last_name").val();
    var email = $("#email").val(); 
    var order_time = $("#purchase_order").val();
    var product = $("#cars").find(":selected").val(); 
    var quantityAvail = parseInt($("#available").val()); 
    var quantitySelected = parseInt($("#quantity").val()); 
    var complete = false; 

    var dataString = 'email=' + email + '&prodID=' + product + '&quantity=' + quantitySelected + '&time=' + order_time + '&first_name=' + fName + '&last_name=' + lName;

    //gets to see if any of the fields are empty 
    if(fName === "" || lName === "" || email === "") {
        alert("Please Fill All Fields"); 
    }
    if(product === "") {
        alert("Please Select A Car");
    }
    //make sure quantity purchased doesn't exceed quantity available 
    if(quantitySelected > quantityAvail) {
        alert("Quantity entered (" + quantitySelected + ") is greater than available (" + quantityAvail + ")!");
    }
    if(fName != "" && lName != "" && email != "" && product != "") {
        complete = true; 
    }
    if(complete == true) {
        $.ajax ({
            type: "POST",
            url: "Unit6_ajaxsubmit.php",
            data: dataString,
            cache: false,
            success: function(result){
                $("#customers").css("display", "none");
                $("#first_name").val("");
                $("#last_name").val("");
                $("#email").val("");
                $("#cars").val("");
                $("#available").val("");
                $("#quantity").val(1);
                $("#orderForm").html(result); 
            }
        });
    }
}

function updateValue() {
    var inactive = $("#inactive");
    var hiddenValue = $("#inactiveValue");
    if(inactive.prop("checked")) {
        hiddenValue.val("1");
    }
    else {
        hiddenValue.val("0");
    }
}

function checkValid(clickedBtn) {
    //get all fields 
    var carName = $("#car_name");
    var carImg = $("#img_name");
    var price = $("#price");
    var quantity = $("#quantity");
    var inactive = $("#inactive");
    var inactiveValue = $("#inactiveValue");
    var product_id = $("#product_id"); 

    //if a field is empty, display the appropriate message and focus cursor
    if(carName.val() === "") {
        $("#no_name").css("display", "block");
        carName.focus();
    }
    if(carImg.val() === "") {
        $("#no_img").css("display", "block");
    }
    if(price.val() === "") {
        $("#no_price").css("display", "block");
    }
    //if form is submitted again, and required fields are 
    //filled in, remove message 
    if(carName.val() != "") {
        $("#no_name").css("display", "none");
        carImg.focus();
    }
    if(carImg.val() != "") {
        $("#no_img").css("display", "none");
        price.focus();
    }
    if(price.val() != "") {
        $("#no_price").css("display", "none");
    }

    //depending on which type of button what clicked, make respective Ajax call
    var btn = $(clickedBtn).attr("id");
    var dataString = 'car=' + carName.val() + '&img=' + carImg.val() + '&quantity=' + quantity.val() + '&price=' + price.val() + '&inactive=' + inactiveValue.val() + '&product_id=' + product_id.val();
    if(carName.val() != "" && carImg.val() != "" && price != "") {
        if(btn === "add") {
            console.log("add shit");
            $.ajax ({
                type: "POST",
                url: "Unit6_addcar.php",
                data: dataString,
                cache: false,
                success: function(result) {
                    carName.val("");
                    carImg.val("");
                    quantity.val("");
                    price.val("");
                    inactive.prop("checked", false);
                    $("#products_table").html(result);
                }
            });
        }
        if(btn === "update") {
            console.log("update shit");
            $.ajax ({
                type: "POST",
                url: "Unit6_updatecar.php",
                data: dataString,
                cache: false,
                success: function(result) {
                    carName.val("");
                    carImg.val("");
                    quantity.val("");
                    price.val("");
                    inactive.prop("checked", false);
                    $("#products_table").html(result);
                }
            });
        }
        if(btn === "delete") {
            console.log("delete shit");
            $.ajax ({
                type: "POST", 
                url: "Unit6_deletecar.php",
                data: dataString, 
                cache: false, 
                success: function(result) {
                    var deleteCar = window.confirm("Do you really want to delete");
                    if(deleteCar) {
                        carName.val("");
                        carImg.val("");
                        quantity.val("");
                        price.val("");
                        inactive.prop("checked", false);
                        $("#products_table").html(result);
                    }
                }
            });
        }
    }
}

function populateProduct() {
    var table = document.getElementById("customers");
    var cells = document.getElementsByTagName("td");

    for(var i = 0; i < cells.length; i++) {
        var cell = cells[i];
        cell.onclick = function() {
            var currentRow = this.parentNode; 
            currentRow.style.backgroundColor = "yellow"; 
            var currentRowCells = currentRow.getElementsByTagName("td");
            $("#car_name").val(currentRowCells[1].textContent);
            $("#img_name").val(currentRowCells[2].textContent);
            $("#quantity").val(currentRowCells[4].textContent);
            $("#price").val(currentRowCells[3].textContent);
            if(currentRowCells[5].textContent === "Yes") {
                $("#inactive").prop("checked", true);
            }
            else {
                $("#inactive").prop("checked", false);
            }
            $("#product_id").val(currentRowCells[0].textContent);
        }
    }
}


function showAvailable(product) {
    const numAvailable = document.getElementById("available"); 
    var productID = product.value; 
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            quantity = this.responseText;
            numAvailable.value = quantity;
        }
    }
    xmlhttp.open("GET", "Unit6_get_quantity.php?id=" + productID, true);
    xmlhttp.send(); 
}

function setCookie(name, value, daysToLive) {
    // Encode value in order to escape semicolons, commas, and whitespace
    var cookie = name + "=" + encodeURIComponent(value);
    
    if(typeof daysToLive === "number") {
        /* Sets the max-age attribute so that the cookie expires
        after the specified number of days */
        cookie += "; max-age=" + (daysToLive*24*60*60);
        
        document.cookie = cookie;
    }
}

function getCookie(name) {
    // Split cookie string and get all individual name=value pairs in an array
    var cookieArr = document.cookie.split(";");
    
    // Loop through the array elements
    for(var i = 0; i < cookieArr.length; i++) {
        var cookiePair = cookieArr[i].split("=");
        
        /* Removing whitespace at the beginning of the cookie name
        and compare it with the given string */
        if(name == cookiePair[0].trim()) {
            // Decode the cookie value and return
            return decodeURIComponent(cookiePair[1]);
        }
    }
    // Return null if not found
    return null;
}

function getViewingHistory() {
    console.log("getting viewing history");
    console.log(products.length);
    //turn array of viewed products into a string and create a cookie with the viewed products
    var json_str = JSON.stringify(products);
    console.log(json_str);
    setCookie("products", json_str, 7);
}

function printViewingHistory(pruchasedProduct) {
    var json_str = getCookie("products");
    var cookies = JSON.parse(json_str);
    var purchasedIDX = cookies.indexOf(pruchasedProduct);
    cookies.splice(purchasedIDX, 1); 
    if(cookies.length > 1) {
        var product_list = $("#viewed_products"); 
        for(var i = 0; i < cookies.length; i++) {
            product_list.append("<li>" + cookies[i] + "</li>");
        } 
    }
    else {
        console.log("only one product viewed")
        $(".deals").css("display", "none");
    }
    setCookie("products", "", -1); 
}