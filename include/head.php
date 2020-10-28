<?php

// Want to see errors!!!!!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$config_json = file_get_contents("./config.json");
$config = json_decode($config_json);

if ((!array_key_exists('logged_in', $_SESSION) || $_SESSION['logged_in'] !== true) && 
    basename($_SERVER["SCRIPT_FILENAME"]) != "login.php" && basename($_SERVER["SCRIPT_FILENAME"]) != "patient-signup.php" && 
    !array_key_exists('test', $_GET)) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login.php');
}

?>