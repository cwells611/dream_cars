<?php
session_start();
//unset session variables 
$_SESSION = array();
//destroy session
session_destroy();
//redirect to index page 
header("Location: Unit6_index.php");
?> 