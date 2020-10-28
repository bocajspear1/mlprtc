<?php include('include/head.php'); ?>
<?php include("include/database.php"); ?>
<?php include('include/header.php') ?>
<?php
    if ($_SESSION['usertype'] != 'admin') {
        echo "<h1>Permission denied!</h1>";
        exit(1);
    }
    
    $d_firstname = "";
    $d_lastname = "";
    $d_notes = "";
    if (array_key_exists('firstname', $_POST) && array_key_exists('lastname', $_POST)) {

        if (!array_key_exists('id', $_POST)) {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $notes = $_POST['notes'];

            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $code = substr(str_shuffle($permitted_chars), 0, 6);

            $query = "INSERT INTO patients (firstname, lastname, notes, code) VALUES ('$firstname', '$lastname', '$notes', '$code')";
            $result = $mysqli->query($query);

            if ($result === TRUE) {
                header('Location: http://' . $_SERVER['HTTP_HOST'] . '/patient.php?id=' . $mysqli->insert_id);
            } else {
                echo "Insert failed (" . $mysqli->errno . ") " . $mysqli->error;
                exit(1);
            }
        } else {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $notes = $_POST['notes'];
            $query = "UPDATE patients SET firstname='$firstname', lastname='$lastname', notes='$notes' WHERE patient_id=" . $_POST['id'];
            $result = $mysqli->query($query);

            if ($result === TRUE) {
                header('Location: http://' . $_SERVER['HTTP_HOST'] . '/patient.php?id=' . $_POST['id']);
            } else {
                echo "Update failed (" . $mysqli->errno . ") " . $mysqli->error;
                exit(1);
            }
        }
        
    } else {
        if (array_key_exists('id', $_GET)) {
            $result = $mysqli->query("SELECT * FROM patients WHERE patient_id=" . $_GET['id']);
            $row = $result->fetch_assoc();
            $d_firstname = $row['firstname'];
            $d_lastname = $row['lastname'];
            $d_notes = $row['notes'];
        }
        
    }


?>

<main>
    <h2>
    <?php 
        if (!array_key_exists('id', $_GET)) {
            echo "New Patient";
        } else {
            echo "Edit Patient";
        }
    ?>   
    </h2>

    <form method="post" action="patient.php" id="patient-form">
        
        <label for="firstname">First Name</label>
        <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $d_firstname?>" placeholder="Firstname">
    
        <label for="lastname">Last Name</label>
        <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $d_lastname?>" placeholder="Lastname">
        <br>
        <label for="notes">Notes</label>
        <textarea cols='50' rows='10' name='notes' id='notes'><?php echo $d_notes?></textarea>

        <?php
        if (array_key_exists('id', $_GET)) {
            echo '<input type="hidden" name="id" id="id" value="' . $_GET['id'] . '">';
        }
        ?>
        <br>

        <button type="submit" class="btn btn-primary">Update Patient</button>
    </form>
    

</main>

<?php include 'include/footer.php' ?>