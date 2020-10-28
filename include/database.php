<?php

$mysqli = new mysqli($config->database_host, $config->database_user, $config->database_password, $config->database_name);

if ($mysqli->connect_errno) {
    echo "<div class='error'>";
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    echo "</div>";
}

?>