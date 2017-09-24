<?php

namespace database;

class seed {
    
    protected $container;
    protected $db;

    function __construct(\Slim\Container $container) {
        $this->container = $container;
        $this->db = $this->container->db;
    }

    function update() {
        if (!$this->container->db->has("sqlite_master", ["AND" => ["type" => "table", "OR" => [
            "name" => ["users", "systems", "categories"]
        ]]])) {
            $this->seed();
        }
    }

    function seed() {
        $this->container->logger->addInfo("Seeding database");
        $this->db->query("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY,
            name TEXT,
            pass TEXT,
            token TEXT NULL,
            level INTEGER DEFAULT 0,
            lastActive INTEGER NULL
        );");

        if (!$this->db->has("users", ["name" => "admin"])) {
            $this->container->logger->addInfo("Seed: admin");
            $this->db->insert("users", [
                "name" => "admin", 
                "pass" => password_hash("admin", PASSWORD_DEFAULT)
            ]);
        }

        $this->db->query("CREATE TABLE IF NOT EXISTS systems (
            id INTEGER PRIMARY KEY,
            uid TEXT,
            name TEXT,
            category INTEGER DEFAULT 0,
            approved BOOLEAN DEFAULT 0,
            wikilink TEXT NULL,
            lastActive INTEGER NULL
        );");

        $this->db->query("CREATE TABLE IF NOT EXISTS categories (
            id INTEGER PRIMARY KEY,
            name TEXT,
            config TEXT
        );");

        if (!$this->db->has("categories", ["id" => "0"])) {
            $this->container->logger->addInfo("Seed: categories");
            $this->db->insert("categories", [
                "id" => 0,
                "name" => "Default",
                "config" => file_get_contents(__DIR__."/../app/default.conf")
            ]);
        }
    }
}
