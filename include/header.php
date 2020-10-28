<!DOCTYPE html>

<html>

<head>
	<title>MLPRTC - Medical Ledger & Patient Record Telehealth Console</title>
    
    <link rel="stylesheet" href="static/mini-default.min.css">
    <link rel="stylesheet" href="static/site.css">
</head>

<body>
<header>
    <header>
        <a href="#" class="logo">MLPRTC</a>
        <?php
            if (array_key_exists('logged_in', $_SESSION) && $_SESSION['logged_in'] === true) {
                echo '<a href="index.php" class="button">Home</a>';
                if ($_SESSION['usertype'] == "admin") {
                    echo '<a href="advanced.php" class="button">Advanced</a>';
                }
                echo '<a href="logout.php" class="button">Logout</a>';
            } else {
                echo "<a href='login.php'>Login</a>";
            }

        ?>
        
    </header>
    <ul>
        
                <li><a href="page.php">Users</a></li>
                <li><a href="index.php">Home</a></li>
    </ul>
</header>