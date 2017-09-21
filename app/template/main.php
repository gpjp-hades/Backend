<?php
require "app/template/navbar.php";
$db = new app\db();
?>

<div class="container">
<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-primary">
    <div class="panel-heading"><strong>Pending approval</strong></div>
    <div class="panel-body">
        <?php
            $pending = $db->select("pc", ["name", "uid"], ["approved" => false]);
            if (count($pending)) {
                echo "<div class='list-group'>";
                foreach($pending as $pc) {
                    echo "<a class='list-group-item list-group-item-danger' href='?info=" . $pc['uid'] . "'>" . (strlen($pc['name']) ? $pc['name'] : "uid: " . $pc['uid']) . "</a>" . PHP_EOL;
                }
                echo "</div>";
            } else {
                echo "<span class='text-muted'>None</span>";
            }
        ?>
    </div>
    </div>
    <div class="panel panel-default">
    <div class="panel-heading"><strong>Systems</strong></div>
    <div class="panel-body">
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
                echo "<span class='text-muted'>None</span>";
            }
        ?>
    </div>
    </div>
    <div class="panel panel-default">
    <div class="panel-heading"><strong>Groups</strong></div>
    <div class="panel-body">
        <?php
            echo "<div class='list-group'>";
            foreach ($db->select("categories", "*") as $group) {
                echo "<a class='list-group-item' href='?group=" . $group['id'] . "'>" . $group['name'] . "</a>" . PHP_EOL;
            }
            echo "</div>";
        ?>
        <a href="?group=new">Create new group</a>
    </div>
    </div>
    </div>
</div>
</div>
</div>