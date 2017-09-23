<?php
require __dir__."/../layout/app.php";
?>

<div class="container">
<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-primary">
    <div class="panel-heading"><strong>Pending approval</strong></div>
    <div class="panel-body">
        <?php
            $pending = $GLOBALS["PENDING"];
            if (count($pending)) {
                echo "<div class='list-group'>";
                foreach($pending as $pc) {
                    echo "<li class='list-group-item'><a class='list-group-item-heading' href='?info=" . $pc['uid'] . "'><strong>" . (strlen($pc['name']) ? $pc['name'] : "unknown") . " </strong></a>" . PHP_EOL;
                    echo "<br /><code>" . $pc['uid'] . "</code></li>";
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
            $approved = $GLOBALS["APPROVED"];
            if (count($approved)) {
                echo "<ul class='list-group'>";
                foreach($approved as $pc) {
                    echo "<li class='list-group-item'><h4 class='list-group-item-heading'>";
                    if (strlen($pc['wikilink'])) {
                        echo "<a href='" . $pc['wikilink'] . "' class='btn btn-default pull-right btn-xs'>DokuWiki</a>";
                    }
                    echo "<a href='?info=" . $pc['uid'] . "'>" . $pc['name'] . "</a>";
                    echo "<br /><small> UID:<code>".$pc['uid']."</code></small>";
                    echo "</h4><p class='list-group-item-text'>";
                    echo "Group: <strong>" . $GLOBALS["ASSOC"][$pc['category']] . "</strong><br />";
                    echo "Last active: <strong>" . date('d. m. Y H:i:s',  $pc['lastActive']) . "</strong>";
                    echo "</p></li>" . PHP_EOL;
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
            foreach ($GLOBALS["GROUPS"] as $group) {
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