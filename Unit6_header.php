<?php
if(session_status() <> PHP_SESSION_ACTIVE) session_start();

if(!isset($_SESSION['role'])) {
    $_SESSION['role'] = -1;
}
?>
<link rel="stylesheet" href="Unit6_common.css">
<?php if($_SESSION['role'] == -1): ?>
    <nav>
        <ul>
            <li><a id="home" href="Unit6_index.php">Home</a></li>
            <li><a id="store" href="Unit6_store.php">Store</a></li>
        </ul>
    </nav>
<?php elseif($_SESSION['role'] == 1): ?>
    <nav>
        <ul>
            <li><a id="home" href="Unit6_index.php">Home</a></li>
            <li><a id="order_entry" href="Unit6_order_entry.php">Order Entry</a></li>
            <li><a id="admin" href="Unit6_admin.php">Admin</a></li>
            <?php echo "<li style = 'float:right'><a href='Unit6_logout.php'>Logout</a></li>"; ?>
        </ul>
    </nav>
<?php else: ?>
    <nav>
        <ul>
            <li><a id="home" href="Unit6_index.php">Home</a></li>
            <li><a id="store" href="Unit6_store.php">Store</a></li>
            <li><a id="order_entry" href="Unit6_order_entry.php">Order Entry</a></li>
            <li><a id="admin" href="Unit6_admin.php">Admin</a></li>
            <?php echo "<li style = 'float:right'><a href='Unit6_logout.php'>Logout</a></li>"; ?>
        </ul>
    </nav>
<?php endif; ?>

<header>
    <h2>The Place to Find Your Dream Car</h2>
    <h4>Showing you how expensive your dream car is since 2023</h4>
    <?php 
    if($_SESSION['role'] == 1 || $_SESSION['role'] == 2) {
        echo "<p class='welcome'>Welcome, " . $_SESSION['first_name'] . "</p>";
    }
    ?>
</header>