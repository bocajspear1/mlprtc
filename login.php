<?php include('include/head.php') ?>
<?php include("include/database.php"); ?>

<?php

$ERROR = "";

if (array_key_exists('username', $_POST) && array_key_exists('password', $_POST))  {

    $username = $_POST['username'];
    $password = $_POST['password'];


    if ($username == $config->admin_username && $password == $config->admin_password) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['usertype'] = "admin";
        $_SESSION['usertype'] = 0;
    } else {
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";

        $result = $mysqli->query($query);

        if (!$result) {
            $ERROR = "Failed to query: (" . $mysqli->errno . ") " . $mysqli->error;
        } else {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['usertype'] = $row['usertype'];
                $_SESSION['patient_id'] = $row['patient_id'];
                header('Location: index.php');
            }
        }
        $ERROR = "Invalid login!";
    }

    if ($ERROR == "") {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/');
    }

    

}
?>


<?php include 'include/header.php' ?>


<div class="container">
  <div class="row">
    <div class="col-sm">
    </div>
    <!-- Adding some flex properties to center the form and some height to the page, these can be omitted -->
    <div class="col-sm-12 col-md-8 col-lg-6">
      <form method="post">
            <h4>
                Medical Ledger & Patient Record Telehealth Console
            </h4>
        <fieldset>
            <legend>Login</legend>
            <div class="input-group fluid">
              <label for="username" style="width: 80px;">Username</label>
              <input type="text" value="" id="username" name="username" placeholder="Username">
            </div>
            <div class="input-group fluid">
              <label for="password" style="width: 80px;">Password</label>
              <input type="password" value="" id="password" name="password" placeholder="Password">
            </div>
            <div class="input-group fluid">
              <input type="submit" class="primary" value="Login">
              <a href="patient-signup.php">Patient Signup</a>
            </div>
        </fieldset>
      </form>
    </div>
    <div class="col-sm">
    </div>
  </div>
</div>

<?php include 'include/footer.php' ?>