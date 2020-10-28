<?php include('include/head.php'); ?>
<?php include("include/database.php"); ?>
<?php include('include/header.php') ?>

<?php
if ($_SESSION['usertype'] != 'admin') {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/visit_list.php?patient=' . $_SESSION['patient_id']);
}
?>

<main>
    <h2>
        Patients
    </h2>
    <a href="patient.php" class="button">+ New Patient</a>
    <a href="visit.php" class="button">+ New Visit</a>
    <table id="patient-list">
        <thead>
            <tr>
            <th>Patient Name</th>
            <th>Visits</th>
            <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $query = "SELECT * FROM patients;";

                $result = $mysqli->query($query);
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo '<td>' . $row['firstname'] . ' ' . $row['lastname']  . '</td>';
                    $query2 = "SELECT * FROM visits WHERE patient_id=" . $row['patient_id'];
                    $result2 = $mysqli->query($query2);
                    $visit_count = $result2->num_rows;
                    echo '<td><a href="visit_list.php?patient=' . $row['patient_id'] . '">' . $visit_count  . '</a></td>';
                    echo '<td><a href="patient.php?id=' . $row['patient_id'] . '">Edit</a></td>';
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>


</main>

<?php include 'include/footer.php' ?>