<?php

namespace app;

class index {
    function __construct() {
        require "app/auth.php";

        $this->auth = new auth();

        if ($this->auth->logged()) {
            if (
                is_string(@$_POST['uname']) && 
                is_string(@$_POST['passw']) && 
                is_string(@$_POST['passw2']) && 
                @$_POST['type'] == "reg"
            ) {
                if (!strlen($_POST['uname'])) {
                    $error = "You must enter username";
                    require "app/template/auth/register.php";
                    exit;
                } else if (!strlen($_POST['passw'])) {
                    $error = "You must enter password";
                    require "app/template/auth/register.php";
                    exit;
                } else if (preg_match('/[^\x20-\x7f]/', $_POST['uname'])) {
                    $error = "Use only ASCII in username";
                    require "app/template/auth/register.php";
                    exit;
                } else if ($_POST['passw'] != $_POST['passw2']) {
                    $error = "Passwords don't match";
                    require "app/template/auth/register.php";
                    exit;
                } else {
                    if ($this->auth->register($_POST['uname'], $_POST['passw'])) {
                        $status = "Account created successfully";
                    } else {
                        $error = "username alredy taken";
                        require "app/template/auth/register.php";
                        exit;
                    }
                }
            }

            if (
                is_string(@$_POST['old']) && 
                is_string(@$_POST['passw']) && 
                is_string(@$_POST['passw2']) && 
                @$_POST['type'] == "change"
            ) {
                if ($_POST['passw'] != $_POST['passw2']) {
                    $error = "Passwords don't match";
                    require "app/template/auth/changePassw.php";
                    exit;
                } else if (!strlen($_POST['passw'])) {
                    $error = "You must enter password";
                    require "app/template/auth/register.php";
                    exit;
                } else if (!$this->auth->checkPassword($_POST['old'])) {
                    $error = "Wrong current password";
                    require "app/template/auth/changePassw.php";
                    exit;
                } else {
                    $this->auth->chagePassw($_POST['passw']);
                    $status = "Password changed successfully";
                }
            }

            if (isset($_GET['logout'])) {
                if ($this->auth->logout()) {
                    header("Location: .");
                    exit;
                } else {
                    $error = "Logout failed";
                }
            } else if (isset($_GET['register'])) {
                require "app/template/auth/register.php";
                exit;
            } else if (isset($_GET['change'])) {
                require "app/template/auth/changePassw.php";
                exit;
            } else if (isset($_GET['info'])) {
                unset($this->auth);
                require "app/template/info/system.php";
                exit;
            } else if (isset($_GET['group'])) {
                unset($this->auth);
                require "app/template/info/group.php";
                exit;
            } else if (isset($_GET['users'])) {
                unset($this->auth);
                require "app/template/users.php";
                exit;
            }


            require "app/template/main.php";
        } else if (is_string(@$_POST['uname']) && is_string(@$_POST['passw']) && @$_POST['type'] == "login") {
            if ($this->auth->login($_POST['uname'], $_POST['passw'])) {
                header("Location: .");
                exit;
            }

            $error = "Login failed";
            require "app/template/auth/login.php";
        } else {
            require "app/template/auth/login.php";
        }
    }
}

new index();