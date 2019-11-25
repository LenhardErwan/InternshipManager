<?php
    define("DB_HOST", "%host%");
    define("DB_PORT", "%port%");
    define("DB_DATABASE", "%name%");
    define("DB_SCHEMA", "InternshipManager");
    define("DB_USERNAME", "%username%");
    define("DB_PASSWORD", "%password%");

    try {
        $database = new PDO('pgsql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_DATABASE.';user='.DB_USERNAME.';password='.DB_PASSWORD);
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $database->exec("SET NAMES 'utf8'; SET search_path TO ".DB_SCHEMA.";");
    } catch (Exception $e) {
        die("ERREUR : ".$e->getMessage());
    }
?>