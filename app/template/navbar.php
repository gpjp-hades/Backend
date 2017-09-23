<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Config deployment</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?=strtok($_SERVER["REQUEST_URI"],'?')?>">Config Deployment</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
        <?php
        require_once "app/auth.php";
        if ($uname = \app\auth::auth()) {
            echo <<<EOF
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <span class="glyphicon glyphicon-user"></span>
                    $uname
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <li><a href="?logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                    <li><a href="?change"><span class="glyphicon glyphicon-lock"></span> Change password</a></li>
                    <li role="presentation" class="divider"></li>
                    <li><a href="?users"><span class="glyphicon glyphicon-briefcase"></span> Manage users</a></li>
                    <li><a href="?register"><span class="glyphicon glyphicon-plus"></span> Register new user</a></li>
                </ul>
            </li>
          </ul>
EOF;
        }
        ?>
    </div>
    </div>
</nav>
<div class="container">
<div class="col-md-6 col-md-offset-3">
<?php
if (is_string(@$error)) {
    echo "<div class='alert alert-danger'>
        <strong>Error!</strong> $error
    </div>";
}
if (is_string(@$status)) {
    echo "<div class='alert alert-success'>
    <strong>Success!</strong> $status
</div>";
}
?>
</div>
</div>