<?php include('include/head.php'); ?>
<?php include("include/database.php"); ?>
<?php include('include/header.php') ?>
<?php
$ERROR = "";
$OKAY = FALSE;
if (array_key_exists('username', $_POST) && array_key_exists('password', $_POST) && array_key_exists('fullname', $_POST) && array_key_exists('code', $_POST))  {

    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $usertype = $_POST['usertype'];
    $password = $_POST['password'];
    $code = $_POST['code'];

	// Stop SQL injection
    // Was having some problems, disabled for now
	// $username = str_replace("'", "\'", $username);
    // $username = str_replace('"', '\"', $username);
    
    $query = "SELECT * FROM patients WHERE code='$code'";
    $result = $mysqli->query($query);

    if ($result->num_rows == 0) {
        echo "Invalid code, please ensure you typed the code correctly!";
        exit(1);
    }

    $patient_data = $result->fetch_assoc();

	$query = "SELECT * FROM users WHERE username='" . $username . "'";

	$result = $mysqli->query($query);

	if (!$result) {
		$ERROR = "Failed to query: (" . $mysqli->errno . ") " . $mysqli->error;
	} else {
        if ($result->num_rows > 0) {
            $ERROR = "The username you selected is already being used, please try another.";
        } else {
            $query = "INSERT INTO users (username, fullname, password, usertype, patient_id) VALUES ('$username', '$fullname', '$password', '$usertype', " . $patient_data['patient_id'] . ")";
            $result = $mysqli->query($query);

            if ($result === TRUE) {
                $OKAY = TRUE;
            } else {
                $ERROR = "Insert failed (" . $mysqli->errno . ") " . $mysqli->error;
            }
        }
    }
}
?>


<main>
   
    <?php if ($ERROR != "") : ?>
    <div class="error">
        <?php echo($ERROR); ?>
    </div>
    <?php endif; ?>

    <?php if ($OKAY) : ?>
    <div class="alert alert-success">
        Account created!
    </div>
    <?php endif; ?>

    <form method="post" action="patient-signup.php" id="signup-form">
        
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" id="username" placeholder="Username">
        <br>
        <label for="fullname">Full Name</label>
        <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name">
        <br>
        <label for="username">Password</label>
        <input type="password" class="form-control" name="password" id="password">
        <br>
        <label for="code">Code (Get this from your provider)</label>
        <input type="text" class="form-control" name="code" id="code" placeholder="6-digit code">
        <br>
        <input type="hidden" value="patient" name="usertype" id="usertype">

        <button type="submit" class="btn btn-primary">Sign Up!</button>
    </form>

</main>

<?php include 'include/footer.php' ?>