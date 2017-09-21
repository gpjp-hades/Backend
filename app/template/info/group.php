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

require "app/template/navbar.php";
?>

Group information:
<?php
    if (!is_string($_GET['group']))
        exit("No arguemnt suplied");
    
    if ($_GET['group'] == "new") {
        $info = ["name" => "New group", "id" => "new", "config" => ""];
    } else {
        $info = $db->get("categories", "*", ["id" => $_GET['group']]);
        if (!$info)
            exit("Group not found");
    }
?>
<h1><?=$info['name']?></h1>
Config:
<form method="post">
    <input type="hidden" name="type" value="group">
    <input type="hidden" name="id" value="<?=$info['id']?>">
    <?php
        if ($info['id'] == "new")
            echo '<input type="text" name="name" placeholder="Group name">';
    ?>
    <textarea name="config" cols="30" rows="10"><?=$info['config']?></textarea>
    <input type="submit" value="Update">
</form>
<a href="?group=<?=$info['id']?>&delete">Remove group</a>