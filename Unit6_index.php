<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Caden Wells">
    <title>Dream Cars</title>
    <link rel="stylesheet" href="Unit6_login.css">
    <script src="Unit6_script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<body>
    <header id="index_header">
        <?php include 'Unit6_header.php'; ?>
    </header>
    <?php include 'Unit6_database.php';?>

    <section id="login_section">
        <p id="welcome">Welcome! Please login or select <i>Continue as Guest</i> to begin<span id="error"><?php echo isset($_GET['err']) ? ' ' . $_GET['err'] : ''; ?></span></p>
        <form id="login_form" method="POST" action="Unit6_login.php">
            <label for="email"><strong>Email</strong></label><br>
            <input type="email" id="email" name="email" required><br><br>
            <label for="password"><strong>Password</strong></label><br>
            <input type="password" id="password" name="password" required><br><br>
            <button id="login" name="login" type="submit">Login</button><br><br>
            <input id="remember" name="remember" type="checkbox">
            <label for="remember">Remember Me</label>
            <a id="forgot_pass" href="Unit6_index.php">Forgot Password</a>
        </form>
        <br>
        <a href="Unit6_store.php" target="_self"><button id="guest" name="guest" type="button">Continue as Guest</button></a>
    </section>

    <footer id="index_footer">
        <?php include 'Unit6_footer.php';?>
    </footer>
</body>
</html>