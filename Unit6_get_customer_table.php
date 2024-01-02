<?php
include 'Unit6_database.php'; 
$conn = getConnection();

$letters = $_REQUEST["letter"]; 
$name_type = $_REQUEST["name_type"]; 

//convert letters put in form to lowercase and get length 
$letters = strtolower($letters);
$len = strlen($letters);

//get all the customers in the database 
$customers = getCustomers(); 

$match = false; 
//if the first_name field is being filled, check DB for matching first name sequences
//if last_name field is being filled, check DB for matching last name sequences 
if($customers->num_rows > 0) {
    if($name_type === 'first') {
        foreach ($customers as $customer) {
            $fName = $customer['first_name'];
            if(stristr($letters, substr($fName, 0, $len))) {
                if(!$match) {
                    echo "<table id='customers'>";
                    echo "<tr>";
                    echo "<th>First Name</th>";
                    echo "<th>Last Name</th>";
                    echo "<th>Email</th>";
                    echo "</tr>";
                    $match = true; 
                }
                echo "<tr>";
                echo "<td>" . $customer['first_name'] . "</td>";
                echo "<td>" . $customer['last_name'] . "</td>";
                echo "<td>" . $customer['email'] . "</td>";
                echo "</tr>";
            }
        }
        if(!$match) {
            echo "No matching customers";
        }
        if($match) {
            echo "</table>"; 
        }
    }
    else {
        foreach ($customers as $customer) {
            $lName = $customer['last_name'];
            if(stristr($letters, substr($lName, 0, $len))) {
                if(!$match) {
                    echo "<table id='customers'>";
                    echo "<tr>";
                    echo "<th>First Name</th>";
                    echo "<th>Last Name</th>";
                    echo "<th>Email</th>";
                    echo "</tr>";
                    $match = true; 
                }
                echo "<tr>";
                echo "<td>" . $customer['first_name'] . "</td>";
                echo "<td>" . $customer['last_name'] . "</td>";
                echo "<td>" . $customer['email'] . "</td>";
                echo "</tr>";
            }
        }
        if(!$match) {
            echo "No matching customers";
        }
        if($match) {
            echo "</table>";
        }
    }
}
?>