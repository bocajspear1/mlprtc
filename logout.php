<?php include('include/head.php'); ?>
<?php
$_SESSION['logged_in'] = false;
$_SESSION['username'] = "";
$_SESSION['usertype'] = "";
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login.php');
?>