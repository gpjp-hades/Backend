<?php
require "app/template/navbar.php";
?>

<form method="post">
    <input type="password" name="old" placeholder="Old password">
    <input type="password" name="passw" placeholder="New password">
    <input type="password" name="passw2" placeholder="New password again">
    <input type="hidden" name="type" value="change">
    <input type="submit" value="Login">
</form>