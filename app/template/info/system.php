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

require "app/template/navbar.php";
?>

System information:
<?php
    if (!is_string($_GET['info']))
        exit("No arguemnt suplied");
    
    $info = $db->get("pc", "*", ["uid" => $_GET['info']]);
    if (!$info)
        exit("PC not found");
?>
<?php
    if ($info['approved'] == false) {
        echo "<h1>System awaiting approval</h1>";
    }
?>
<form method="post">
    Name: <input type="text" name="name" value="<?=$info['name']?>"><br />
    Belongs to group: <select name="group">
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
    <br />
    WikiLink: <input type="text" name="wiki" value="<?=$info['wikilink']?>">
    <input type="hidden" name="type" value="system">
    <input type="hidden" name="id" value="<?=$info['id']?>">
    <br />
    <?php
    if ($info['approved']) {
        echo '<input type="submit" value="Update">';
    } else {
        echo '<input type="submit" value="Approve">';
    }
    ?>
</form>

<a href="?info=<?=$info['uid']?>&delete">Remove machine</a>
