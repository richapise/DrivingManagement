<?php
session_start();


$_SESSION = array();


session_destroy();


header("Location: login_form.php");
exit();
?>


<div class="top-nav">
    <a href="Home.php">Home</a>
    <a href="packages.php">Package</a>
    <a href="login_form.php">Login</a>
    <a href="feedback.php">Feedback</a>
    <a href="register_form.php">Register Now!!</a>
    
   
    <?php if (isset($_SESSION['user_id'])) { ?>
        <a href="logout.php">Logout</a>
    <?php } ?>
</div>
