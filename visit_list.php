<?php include('include/head.php'); ?>
<?php include("include/database.php"); ?>
<?php include('include/header.php') ?>

<main>
    <h2>
        Visits for <?php 
            $query = "SELECT * FROM patients WHERE patient_id=" . $_GET['patient'];

            $result = $mysqli->query($query);
            $row = $result->fetch_assoc();
            echo $row['firstname'] . ' ' . $row['lastname'];
        ?>
    </h2>
    <table id="visit-list">
        <thead>
            <tr>
            <th>Visit Time</th>
            <th>Edit/View</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $query = "SELECT * FROM visits WHERE patient_id=" . $_GET['patient'];

                $result = $mysqli->query($query);
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo '<td>' . $row['visit_time'] . '</td>';
                    if ($_SESSION['usertype'] != 'admin') {
                        echo '<td><a href="visit.php?id=' . $row['visit_id'] . '">View</a></td>';
                    } else {    
                        echo '<td><a href="visit.php?id=' . $row['visit_id'] . '">Edit</a></td>';
                    }
                    
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>


</main>

<?php include 'include/footer.php' ?>