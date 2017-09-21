<?php

namespace app;

require "Medoo.php";

class db extends \Medoo\Medoo {
    function __construct() {
        $config = [
            'database_type' => 'sqlite',
            'database_file' => 'app/database.db'
        ];
        parent::__construct($config);

        $this->query("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY,
            uname TEXT,
            passw TEXT,
            token TEXT NULL
        );");

        if (!$this->has("users", ["uname" => "admin"])) {
            $this->insert("users", ["uname" => "admin", "passw" => password_hash("admin", \PASSWORD_DEFAULT)]);
        }

        $this->query("CREATE TABLE IF NOT EXISTS pc (
            id INTEGER PRIMARY KEY,
            uid TEXT,
            name TEXT,
            category INTEGER DEFAULT 0,
            approved BOOLEAN DEFAULT 0,
            wikilink TEXT NULL,
            lastActive INTEGER NULL
        );");

        $this->query("CREATE TABLE IF NOT EXISTS categories (
            id INTEGER PRIMARY KEY,
            name TEXT,
            config TEXT
        );");

        if (!$this->has("categories", ["id" => "0"])) {
            $this->insert("categories", ["id" => 0, "name" => "Default", "config" => file_get_contents("app/template/default.conf")]);
        }

    }
}