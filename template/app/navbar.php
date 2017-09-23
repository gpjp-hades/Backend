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
        if ($uname = \hades\app\middleware\auth::auth()) {
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