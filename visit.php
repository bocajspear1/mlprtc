<?php include('include/head.php'); ?>
<?php include("include/database.php"); ?>
<?php include('include/header.php') ?>
<?php
    
    
    $d_patient = "";
    $d_temperature = "";
    $d_notes = "";
    $d_upload = "";
    $uploaded_filename = "";
    $disabled = "";

    if ($_SESSION['usertype'] != 'admin') {
        $disabled = " disabled";
    }
    
    if (array_key_exists('patient', $_POST) && array_key_exists('temperature', $_POST)) {
        
        if (count($_FILES) > 0 && array_key_exists('upload_file', $_FILES) && $_FILES['upload_file']['name']) {
            // $upload_filename_items = explode(".", $_FILES['upload_file']['name']);
            // $ext = $upload_filename_items[count($upload_filename_items) - 1];

    
            $filename = $_SESSION['username'] . "." . $_FILES['upload_file']['name'];
            $src = $_FILES['upload_file']['tmp_name'];
    
            $full_path = dirname($_SERVER['SCRIPT_FILENAME']) . "/" . $config->upload_dir . "/" . $filename;
            $move_result = move_uploaded_file($src, $full_path); 
            if ($move_result == TRUE) {
                $uploaded_filename = $filename;
            } else {
                echo "<div class='error'>Upload failed! (Perhaps the file was too big)</div/>";
                exit(1);
            }
        } else {
            echo "<div class='error'>No file uploaded</div>";
        }

        if (!array_key_exists('id', $_POST)) {
            $patient_id = $_POST['patient'];
            $temperature = $_POST['temperature'];
            $notes = $_POST['notes'];
            $query = "INSERT INTO visits (patient_id, temperature, notes, visit_time, upload) VALUES ($patient_id, $temperature, '$notes',  NOW(), '$uploaded_filename')";
            $result = $mysqli->query($query);

            if ($result === TRUE) {
                header('Location: http://' . $_SERVER['HTTP_HOST'] . '/visit.php?id=' . $mysqli->insert_id);
            } else {
                echo "Insert failed (" . $mysqli->errno . ") " . $mysqli->error;
                exit(1);
            }
        } else {
            $patient_id = $_POST['patient'];
            $temperature = $_POST['temperature'];
            $notes = $_POST['notes'];
            $query = "UPDATE visits SET patient_id=$patient_id, temperature=$temperature, notes='$notes' WHERE visit_id=" . $_POST['id'];
            if ($uploaded_filename != "") {
                $query = "UPDATE visits SET patient_id=$patient_id, temperature=$temperature, notes='$notes' upload='$uploaded_filename' WHERE visit_id=" . $_POST['id'];
            }
            $result = $mysqli->query($query);

            if ($result === TRUE) {
                header('Location: http://' . $_SERVER['HTTP_HOST'] . '/visit.php?id=' . $_POST['id'] . "&ok=1");
            } else {
                echo "Update failed (" . $mysqli->errno . ") " . $mysqli->error;
                exit(1);
            }
        }
        
    } else {
        if (array_key_exists('id', $_GET)) {
            $result = $mysqli->query("SELECT * FROM visits WHERE visit_id=" . $_GET['id']);
            $row = $result->fetch_assoc();
            $d_patient = $row['patient_id'];
            $d_temperature = $row['temperature'];
            $d_notes = $row['notes'];
            $d_upload = $row['upload'];
        }
        
    }


?>

<main>
    <h2>
    <?php 
        if ($_SESSION['usertype'] != 'admin') {
            echo "View Visit";
        } else {
            if (!array_key_exists('id', $_GET)) {
                echo "New Visit";
            } else {
                echo "Edit Visit";
            }
        }
    ?>   
    </h2>

    <form method="post" action="visit.php" id="visit-form" enctype="multipart/form-data">

        <label for="patient">Patient</label>
        <select name="patient" id="patient" <?php echo $disabled; ?>>
        <?php
            $query = "SELECT * FROM patients;";

            $result = $mysqli->query($query);
            while($row = $result->fetch_assoc()){
                echo "<option value='";
                echo $row['patient_id'];
                echo "'";
                if ($row['patient_id'] == $d_patient) {
                    echo ' selected';
                }
                echo ">";
                echo $row['firstname'] . ' ' . $row['lastname']  . '</option>';
            }
        ?>
        </select>
        

        <label for="temperature">Temperature</label>
        <input type="text" class="form-control" name="temperature" id="temperature" value="<?php echo $d_temperature?>" <?php echo $disabled; ?>>
        <br>
        <label for="notes">Notes</label>
        <textarea cols='50' rows='10' name='notes' id='notes' <?php echo $disabled; ?>><?php echo $d_notes?></textarea>
        <br>
        <?php
            if ($d_upload != "") {
                echo "<h3>Uploaded File: <a href='uploads/" . $d_upload . "'>" . $d_upload . "</a></h3>";
            }
        ?>
        <label for="upload">Upload File</label>
        <input type='file' class="form-control" name='upload_file' id="upload_file" <?php echo $disabled; ?>/>

        <?php
        if (array_key_exists('id', $_GET)) {
            echo '<input type="hidden" name="id" id="id" value="' . $_GET['id'] . '">';
        }
        ?>
        <br>

        <button type="submit" class="btn btn-primary" <?php echo $disabled; ?>>Update Visit</button>
    </form>
    

</main>

<?php include 'include/footer.php' ?>