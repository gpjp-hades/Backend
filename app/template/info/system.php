<?php
$db = new app\db();

if (@$_POST['type'] == 'system' && is_string($_POST['id'])) {

    $config = [];

    if ($db->has("pc", ["id" => $_POST['id'], "approved" => false])) {
        if (!is_string(@$_POST['name']) || !strlen($_POST['name'])) {
            $error = "Name required";
        } else {
            $config = ["approved" => true];
        }
    }
    
    if (is_string(@$_POST['wiki'])) {
        $config["wikilink"] = $_POST['wiki'];
    }
    if (is_string(@$_POST['name'])) {
        if (preg_match('/[^\x20-\x7f]/', $_POST['name'])) {
            $error = "Use only ASCII in name";
        } else {
            $config["name"] = $_POST['name'];
        }
    }

    if (is_string(@$_POST['group']) && !is_string(@$error)) {
        if ($db->has("categories", ["id" => $_POST['group']]) && $db->has("pc", ["id" => $_POST['id']])) {
            $db->update("pc", ["category" => $_POST['group']], ["id" => $_POST['id']]);
            $status = "Config updated";
        }
    }

    if (count($config) && $db->has("pc", ["id" => $_POST['id']]) && !is_string(@$error)) {
        $db->update("pc", $config, ["id" => $_POST['id']]);
        $status = "Config updated";
    }
}

if (isset($_GET['delete'])) {
    if ($db->has("pc", ["uid" => $_GET['info']])) {
        $db->delete("pc", ["uid" => $_GET['info']]);
        $status = "PC removed";
    } else {
        $error = "PC not found";
    }
}

if (!is_string($_GET['info'])) {
    $error = "No arguemnt suplied";
    require "app/template/navbar.php";
    exit();
}

$info = $db->get("pc", "*", ["uid" => $_GET['info']]);
if (!$info) {
    $error = "System not found";
    require "app/template/navbar.php";
    exit();
}

require "app/template/navbar.php";
?>

<div class="container">
<div class="col-md-6 col-md-offset-3">
    <?php
        if ($info['approved'] == false) {
            echo '<div class="panel panel-success">';
            echo '<div class="panel-heading"><strong>Approve system</strong></div>';
        } else {
            echo '<div class="panel panel-primary">';
            echo '<div class="panel-heading"><strong>System information</strong></div>';
        }
    ?>
    <div class="panel-body">
    <form method="post" class="form-horizontal">
        <input type="hidden" name="type" value="system">
        <input type="hidden" name="id" value="<?=$info['id']?>">
        <div class="form-group v-align">
            <label class="col-md-4 control-label">UID:</label>
            <p class="col-md-6 form-control-static"><code><?=$info['uid']?></code></p>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="name">Name:</label>
            <div class="col-md-6">
                <strong><input class="form-control" type="text" name="name" id="name" value="<?=$info['name']?>" required></strong>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="group">Belongs to group:</label>
            <div class="col-md-6">
                <select name="group" class="form-control" id="group">
                <?php
                    foreach($db->select("categories", ["name", "id"]) as $group) {
                        if ($group['id'] == $info['category']) {
                            echo "<option value='".$group['id']."' selected>".$group['name']."</option>";
                        } else {
                            echo "<option value='".$group['id']."'>".$group['name']."</option>";
                        }
                    }
                ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="wiki">DokuWiki:</label>
            <div class="col-md-6">
                <input class="form-control" type="text" name="wiki" id="wiki" value="<?=$info['wikilink']?>">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <?php
                if ($info['approved']) {
                    echo '<input class="btn btn-primary" type="submit" value="Update">';
                    echo '<a href="?info=' . $info['uid'] . '&delete" class="pull-right text-danger">Remove machine</a>';
                } else {
                    echo '<input class="btn btn-success" type="submit" value="Approve">';
                }
                ?>
            </div>
        </div>
    </form>