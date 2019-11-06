<?php
    //Replace host, port, name, username and password with your values.
    define('DB_HOST', 'host');
    define('DB_PORT', 'port');
    define('DB_DATABASE', 'name');
    define('DB_USERNAME', 'username');
    define('DB_PASSWORD', 'passwd');

    try {
        //replace typeDB by your database type : mysql(MySQL) or psql (PostgreSQL)
        $PDO_BDD = new PDO('typeDB:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_DATABASE.';user='.DB_USERNAME.';password='.DB_PASSWORD);
        $PDO_BDD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $PDO_BDD->exec("SET NAMES 'utf8'");
    } 
    catch (Exception $e) {
        echo 'Error : '.$e->getMessage().'<br />';
        echo 'N° : '.$e->getCode();
        exit();
    }
?>