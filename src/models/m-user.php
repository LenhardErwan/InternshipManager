<?php

require_once("ConfDB.inc.php");

class User {
    public static function getAccount(string $mail) {
        global $database;
        try {
            $request = $database->prepare("SELECT * FROM account A WHERE mail=? ;");
            $request->execute(array($mail)); 
            return $request->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function createAccount(array $data) {
        global $database;
        try {
            $request = $database->prepare("INSERT INTO account (first_name, last_name, mail, password, phone) VALUES (:first_name, :last_name, :mail, :password, :phone);");
            $request->execute($data); 
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function updateAccount(array $data) {
        global $database;
        try {
            $request = $database->prepare("UPDATE account SET first_name = :first_name, last_name = :last_name, mail = :mail, password = :password, phone = :phone WHERE id_account = :id;");
            $request->execute($data); 
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function deleteAccount(int $id) {
        global $database;
        try {
            $request = $database->prepare("DELETE FROM account WHERE id_account = ?;");
            $request->execute($id); 
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }


    public static function getMember(string $mail) {
        global $database;
        try {
            $request = $database->prepare("SELECT * FROM account A JOIN member M ON A.id_account=M.id_member WHERE mail=? ;");
            $request->execute(array($mail)); 
            return $request->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function createMember(array $data) {
        global $database;
        try {
            $request = $database->prepare("SELECT createMember(:first_name, :last_name, :mail, :password, :phone, :birth_date, :degrees) ;");
            $request->execute($data);
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function updateMember(array $data) {
        global $database;
        try {
            updateAccount($data);
            $request = $database->prepare("UPDATE member SET birth_date = :birth_date, degrees = :degrees WHERE id_member = :id;");
            $request->execute($data); 
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function deleteMember(int $id) {
        deleteAccount($id);
    }


    public static function getCompany(string $mail) {
        global $database;
        try {
            $request = $database->prepare("SELECT * FROM account A JOIN company C ON A.i=C.id_company WHERE mail=? ;");
            $request->execute(array($mail)); 
            return $request->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function getCompanyName(int $id) {
        global $database;
        try {
            $request = $database->prepare("SELECT social_reason FROM company WHERE id_company = ? ;");
            $request->execute(array($id)); 
            return $request->fetch(PDO::FETCH_OBJ)->social_reason;
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function createCompany(array $data) {
        global $database;
        try {
            $request = $database->prepare("SELECT createCompany(:first_name, :last_name, :mail, :password, :phone, :social_reason, :degrees) ;");
            $request->execute($data);
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function updateCompany(array $data) {
        global $database;
        try {
        updateAccount($data);
            $request = $database->prepare("UPDATE company SET social_reason = :social_reason, active = :active WHERE id_company = :id;");
            $request->execute($data); 
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function deleteCompany(int $id) {
        deleteAccount($id);
    }
}

?>