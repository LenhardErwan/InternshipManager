<?php
    define('DB_HOST', 'localhost');
    define('DB_PORT', '5432');
    define('DB_DATABASE', 'BDD_Avances');
    define('DB_SCHEMA', 'internshipmanager');
    define('DB_USERNAME', 'test');
    define('DB_PASSWORD', 'test');

    try {
        $DB = new PDO('pgsql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_DATABASE.';user='.DB_USERNAME.';password='.DB_PASSWORD);
        $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $DB->exec("SET NAMES 'utf8'; SET search_path TO ".DB_SCHEMA.";");
    } catch (Exception $e) {
        die("ERREUR".$e);
    }
?>