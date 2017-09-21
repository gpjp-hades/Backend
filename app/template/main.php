<?php
require "app/template/navbar.php";
$db = new app\db();
?>

Pending approval:
<?php
    $pending = $db->select("pc", ["name", "uid"], ["approved" => false]);
    if (count($pending)) {
        echo "<ul>";
        foreach($pending as $pc) {
            echo "<li><a href='?info=" . $pc['uid'] . "'>" . (strlen($pc['name']) ? $pc['name'] : "uid: " . $pc['uid']) . "</a></li>" . PHP_EOL;
        }
        echo "</ul>";
    } else {
        echo "None.<br />";
    }
?>

Systems:
<?php
    $approved = $db->select("pc", "*", ["approved" => true]);
    if (count($approved)) {
        echo "<ul>";
        foreach($approved as $pc) {
            echo "<li><a href='?info=" . $pc['uid'] . "'>" . $pc['name'] . "</a>";
            if (is_string($pc['wikilink'])) {
                echo "<a href='" . $pc['wikilink'] . "'>DokuWiki</a>";
            }
            echo " Group: " . $db->get("categories", "name", ["id" => $pc['category']]);
            echo " Last active at: " . date('Y-m-d H:i:s',  $pc['lastActive']);
            echo "</li>" . PHP_EOL;
        }
        echo "</ul>";
    } else {
        echo "None.<br />";
    }
?>

Groups:
<?php
    echo "<ul>";
    foreach ($db->select("categories", "*") as $group) {
        echo "<li><a href='?group=" . $group['id'] . "'>" . $group['name'] . "</a></li>" . PHP_EOL;
    }
    echo "</ul>";
?>
<a href="?group=new">Create new group</a>