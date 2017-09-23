<?php
require __dir__."/../app/layout.php";
?>
<div class="container">
<div class="col-md-6 col-md-offset-3">
<div class="panel panel-default">
    <div class="panel-heading">Login</div>
    <div class="panel-body">
        <form class="form-horizontal" method="post">
            <input type="hidden" name="type" value="login">
            <div class="form-group">
                <label class="col-md-4 control-label" for="uname">Username:</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" name="uname" id="uname" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="passw">Password:</label>
                <div class="col-md-6">
                    <input class="form-control" type="password" name="passw" id="passw" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <input class="btn btn-primary" type="submit" value="Login">
                </div>
            </div>
        </form>
    </div>
    </div>
</div>
</div>
</div>