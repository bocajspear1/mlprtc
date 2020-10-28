<?php include('include/head.php'); ?>
<?php include("include/database.php"); ?>
<?php include('include/header.php') ?>
<?php
    if ($_SESSION['usertype'] != 'admin') {
        echo "<h1>Permission denied!</h1>";
        exit(1);
    }

    ?>
<main>
    <h2>Files</h2>
    <table id="patient-list">
        <thead>
            <tr>
                <th>Filename</th>
                <th>Permissions</th>
            </tr>
        </thead>
        <tbody>
            <?php 

            $file_list = scandir($config->upload_dir);

            foreach ($file_list as $key => $value) {
                if ($value == "." || $value == "..")  {
                    continue;
                }
                echo "<tr>";
                echo "<td><a href='" . $config->upload_dir . "/" . $value . "'>$value</a></td>";
                echo "<td>" . substr(sprintf('%o', fileperms ( $config->upload_dir . "/" . $value )), -4) . "</td>";
                echo "</tr>";
            }

            ?>
        </tbody>
    </table>

    <h2>Execute Commands</h2>
    <form method="post" action="advanced.php" id="patient-form">
        
        <label for="cmd">System Command</label>
        <input type="text" class="form-control" name="cmd" id="cmd">

        <pre>
            <?php 

            if (isset($_POST['cmd'])) {
                echo trim(passthru($_POST['cmd']));
            }

            ?>
        </pre>

        <button type="submit" class="btn btn-primary">Run</button>
    </form>
    

</main>

<?php include 'include/footer.php' ?>