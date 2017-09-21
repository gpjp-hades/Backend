<?php
$db = new app\db();

if (is_string(@$_GET['remove'])) {
    if ($_GET['remove'] == "admin") {
        $error = "Cannot remove admin";
    } else if (!$db->has("users", ["uname" => $_GET['remove']])) {
        $error = "User not found";
    } else {
        $db->delete("users", ["uname" => $_GET['remove']]);
        $status = "User removed";
    }
}

require "app/template/navbar.php";
?>

<div class="container">
<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
    <div class="panel-heading"><strong>All users</strong></div>
    <div class="panel-body">
        <?php
            $users = $db->select("users", "uname");
            if (count($users)) {
                echo "<ul class='list-group'>";
                foreach($users as $user) {
                    if ($user == 'admin') {
                        echo "<li class='list-group-item'>" . $user . "</li>" . PHP_EOL;
                    } else {
                        echo "<li class='list-group-item'>" . $user;
                        echo "<a href='?users&remove=" . $user . "' class='btn btn-xs pull-right btn-danger'>Remove</a></li>" . PHP_EOL;
                    }
                    
                }
                echo "</ul>";
            } else {
                echo "<span class='text-muted'>No users</span>";
            }
        ?>
    </div>
    </div>
    </div>
    </div>
    </div>