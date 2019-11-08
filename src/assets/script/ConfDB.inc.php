<?php
    define('DB_HOST', 'jeremy-jrm.net');
    define('DB_PORT', '5432');
    define('DB_DATABASE', 'projetPHP');
    define('DB_SCHEMA', 'internshipmanager');
    define('DB_USERNAME', 'projetPHP');
    define('DB_PASSWORD', 'bQER5NUs5636BYeBdCRbmEhEkUJinh8z');

    try {
        $DB = new PDO('pgsql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_DATABASE.';user='.DB_USERNAME.';password='.DB_PASSWORD);
        $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $DB->exec("SET NAMES 'utf8'; SET search_path TO ".DB_SCHEMA.";");
    } catch (Exception $e) {
        die("ERREUR".$e);
    }
?>