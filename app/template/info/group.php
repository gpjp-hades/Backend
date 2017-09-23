<?php
$db = new app\db();

if (@$_POST['type'] == 'group' && is_string($_POST['id']) && is_string($_POST['config'])) {
    if ($db->has("categories", ["id" => $_POST['id']])) {
        $db->update("categories", ["config" => $_POST['config']], ["id" => $_POST['id']]);
        $status = "Config updated";
    } else if (is_string(@$_POST['name'])) {
        if (preg_match('/[^\x20-\x7f]/', $_POST['name'])) {
            $error = "Use only ASCII";
        } else if ($db->has("categories", ["name" => $_POST['name']])) {
            $error = "Name already taken";
        } else {
            $db->insert("categories", ["name" => $_POST['name'], "config" => $_POST['config']]);
            $status = "Group created successfuly";
        }
    }
}

if (isset($_GET['delete'])) {
    if ($db->has("categories", ["id" => $_GET['group']])) {
        $db->delete("categories", ["id" => $_GET['group']]);
        $status = "Group removed";
    } else {
        $error = "Group not found";
    }
}

if (!is_string($_GET['group'])) {
    $error = "No arguemnt suplied";
    require "app/template/navbar.php";
    exit();
}

if ($_GET['group'] == "new") {
    $info = ["name" => "New group", "id" => "new", "config" => ""];
} else {
    $info = $db->get("categories", "*", ["id" => $_GET['group']]);
    if (!$info) {
        $error = "Group not found";
        require "app/template/navbar.php";
        exit();
    }
}

require "app/template/navbar.php";
?>

<div class="container">
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
    <div class="panel-heading"><strong>Group information</div>
    <div class="panel-body">
<form method="post" class="form-horizontal">
    <input type="hidden" name="type" value="group">
    <input type="hidden" name="id" value="<?=$info['id']?>">
    <div class="form-group">
        <div class="col-md-10 col-md-offset-2">
            <p class="lead form-control-static" id="name"><?=$info['name']?></p>
        </div>
    </div>
    <?php
        if ($info['id'] == "new") {
            echo <<<EOL
<div class="form-group">
    <label class="col-md-2 control-label" for="name">Group name:</label>
    <div class="col-md-6">
        <strong><input class="form-control" type="text" name="name" id="name" required></strong>
    </div>
</div>
EOL;
        }
    ?>
    <div class="form-group">
        <label class="col-md-2 control-label" for="config">Config:</label>
        <div class="col-md-10">
            <textarea class="form-control" id="config" name="config" cols="100" rows="20"><?=$info['config']?></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-10 col-md-offset-2" style="margin-top: 5px;">
            <?php
                if ($info['id'] != "new") {
                    echo '<input class="btn btn-primary" type="submit" value="Update">';
                    echo '<a href="?group=' . $info['id'] . '&delete" class="pull-right text-danger">Remove group</a>';
                } else {
                    echo '<input class="btn btn-primary" type="submit" value="Create">';
                }
            ?>  
        </div>
    </div>
</form>