<?php
// Want to see errors!!!!!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<!DOCTYPE html>
<html>

<head>
	<title>MLPRTC Installation Helper</title>
    <style>
        html,body {
            background-color: white;
            font-family: Arial, Helvetica, sans-serif;
        }
        label {
            display: block;
            padding-bottom: 10px;
            padding-top: 10px;
        }
        input {
            width: 40%;
        }
        button {
            padding: 10px;
            margin: 15px;
        }
    </style>
</head>


<body>
    <p>This page will help you setup MLPRTC</p>


    <?php
        $config = null;
        if (file_exists("./config.json")) {
            $config_json = file_get_contents("./config.json");
            $config = json_decode($config_json);
        }

        if (array_key_exists("save", $_POST)) {
            if ($_POST['save'] == 'setup_upload') {
                passthru("mkdir ./" . $_POST['upload_dir'] . "; chmod 775 ./" . $_POST['upload_dir']);
            } elseif ($_POST['save'] == 'save') {
                $output = [
                    'database_host' => $_POST['database_host'],
                    'database_user' => $_POST['database_user'],
                    'database_password' => $_POST['database_password'],
                    'database_name' => $_POST['database_name'],
                    'admin_username' => $_POST['admin_username'],
                    'admin_password' => $_POST['admin_password'],
                    'upload_dir' => $_POST['upload_dir'],
                ];
                file_put_contents("./config.json", json_encode($output));
                $config_json = file_get_contents("./config.json");
                $config = json_decode($config_json);

            }
        }
        
        
        
    ?>

    <div>
        <h3>Config Setup</h3>
        <form method="post" action="install.php">
            <div class="form-group">
                <label for="database_user">Database Host</label>
                <input type="text" class="form-control" name="database_host" placeholder="Database Host" value="<?php if ($config!==null){echo $config->database_host;}?>">
            </div>
            <div class="form-group">
                <label for="database_user">Database Username</label>
                <input type="text" class="form-control" name="database_user" placeholder="Database Username" value="<?php if ($config!==null){echo $config->database_user;}?>">
            </div>
            <div class="form-group">
                <label for="database_password">Database Password</label>
                <input type="password" class="form-control" name="database_password" placeholder="Database Password" value="<?php if ($config!==null){echo $config->database_password;}?>">
            </div>
            <div class="form-group">
                <label for="database_name">Database Name</label>
                <input type="text" class="form-control" name="database_name" placeholder="Database Name" value="<?php if ($config!==null){echo $config->database_name;}?>">
            </div>
            <div class="form-group">
                <label for="admin_username">Admin Username</label>
                <input type="text" class="form-control" name="admin_username" placeholder="Admin Username" value="<?php if ($config!==null){echo $config->admin_username;}?>">
            </div>
            <div class="form-group">
                <label for="admin_password">Admin Password</label>
                <input type="password" class="form-control" name="admin_password" placeholder="Admin Password" value="<?php if ($config!==null){echo $config->admin_password;}?>">
            </div>
            <div class="form-group">
                <label for="database_user">Upload Directory</label>
                <input type="text" class="form-control" name="upload_dir" placeholder="Upload Directory" value="<?php if ($config!==null){echo $config->upload_dir;}?>">
            </div>
            
            <button type="submit" name="save" value="setup_upload">Setup Upload Directory</button>
            <button type="submit" name="save" value="save">Save Config</button>
        </form>
    </div>


</body>