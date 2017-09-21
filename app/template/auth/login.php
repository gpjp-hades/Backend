<?php
require "app/template/navbar.php";
?>

<form method="post">
    <input type="text" name="uname" placeholder="Username">
    <input type="password" name="passw" placeholder="Password">
    <input type="hidden" name="type" value="login">
    <input type="submit" value="Login">
</form>