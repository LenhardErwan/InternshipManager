<?php
require("./install/config.php");

if(!isset($admin_account)) {
	die("Missing array with admin account info");
}
else if(!isset($database_info)) {
	die("Missing array with database info");
}

$conf_template = fopen("./install/ConfDB.template.php", "r");
$conf = fopen("./src/models/ConfDB.inc.php", "w");

if(!$conf_template) {
	die("Fail to open input file, check permissions");
}
else if(!$conf) {
	die("Fail to open output file, check permissions");
}

while(!feof($conf_template)) {
	$line = fgets($conf_template);
	if(preg_match("#%(.*)%#", $line, $matches)) {
		$line = str_replace($matches[0], $database[$matches[1]], $line);
	}
	fputs($conf, $line);
}


require("./src/models/ConfDB.inc.php");

$admin_account["password"] = hash("sha256", $admin_account["password"]);
$DB_script = file_get_contents("./install/DB.sql");

if(!$DB_script) {
	die("Impossible to create database without script");
}

try {
	$database->exec('BEGIN;');
	$create = $database->exec($DB_script);

	$insert = $database->prepare("INSERT INTO account (first_name, last_name, mail, password) VALUES (:first_name, :last_name, :mail, :password);");
	$insert->execute($admin_account);

	$database->exec("COMMIT;");
	echo "Installation done!";
} 
catch (Exception $e) {
	$database->exec("ROLLBACK;");
	die("ERREUR : ".$e->getMessage());
}

?>
