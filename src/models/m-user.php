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

    public static function getAccountByID(int $id) {
        global $database;
        try {
            $request = $database->prepare("SELECT * FROM account A WHERE id_account = ? ;");
            $request->execute(array($id)); 
            return $request->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function getAdmin() {
        global $database;
        try {
            $request = $database->query("SELECT * FROM account WHERE id_account NOT IN (SELECT id_member FROM member) AND id_account NOT IN (SELECT id_company FROM company);");
            $result = $request->fetch(PDO::FETCH_OBJ);
            return $result;
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function isAdmin($id) {
        global $database;
        try {
            $request = $database->query("SELECT id_account FROM account WHERE id_account NOT IN (SELECT id_member FROM member) AND id_account NOT IN (SELECT id_company FROM company);");
            $result = $request->fetch();
            return in_array($id, $result);
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

    public static function updateInfoAccount($data) {
        global $database;   
        try {
            $request = $database->prepare("UPDATE account SET first_name = :first_name, last_name = :last_name, mail = :mail, phone = :phone WHERE id_account = :id;");
            $request->execute($data); 
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function updatePasswordAccount($data) {
        global $database;   
        try {
            $request = $database->prepare("UPDATE account SET password = :password WHERE id_account = :id_account;");
            $request->execute($data); 
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function deleteAccount(int $id) {
        global $database;
        try {
            $request = $database->prepare("DELETE FROM account WHERE id_account = :id_account;");
            $request->execute(array('id_account' => $id)); 
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

    public static function getMemberByID(int $id) {
        global $database;
        try {
            $request = $database->prepare("SELECT * FROM account A JOIN member M ON A.id_account=M.id_member WHERE id_account = ? ;");
            $request->execute(array($id)); 
            return $request->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function getAllMembers() {
        global $database;
        try {
            $request = $database->query("SELECT * FROM member M JOIN account A ON M.id_member=A.id_account;");
            return $request->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function isMember($id) {
        global $database;
        try {
            $request = $database->prepare("SELECT id_member FROM member WHERE id_member = ?;");
            $request->execute(array($id));
            $result = $request->fetch();
            return ($result) ? true : false;
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
            $data_account = array(
                'last_name' => $data['last_name'],
                'first_name' => $data['first_name'],
                'mail' => $data['mail'],
                'phone' => $data['phone'],
                'id' => $data['id']
            );
            self::updateInfoAccount($data_account);

            $data_member = array(
                'birth_date' => $data['birth_date'],
                'degrees' => $data['degrees'],
                'id' => $data['id']
            );
            $request = $database->prepare("UPDATE member SET birth_date = :birth_date, degrees = :degrees WHERE id_member = :id;");
            $request->execute($data_member); 
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
            $request = $database->prepare("SELECT * FROM account A JOIN company C ON A.id_account=C.id_company WHERE mail=? ;");
            $request->execute(array($mail)); 
            return $request->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function getCompanyByID(int $id) {
        global $database;
        try {
            $request = $database->prepare("SELECT * FROM account A JOIN company C ON A.id_account=C.id_company WHERE id_account = ? ;");
            $request->execute(array($id)); 
            return $request->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function getAllCompanies() {
        global $database;
        try {
            $request = $database->query("SELECT * FROM company C JOIN account A ON C.id_company=A.id_account;");
            return $request->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function isCompany($id) {
        global $database;
        try {
            $request = $database->prepare("SELECT id_company FROM company WHERE id_company = ?;");
            $request->execute(array($id));
            $result = $request->fetch();
            return ($result) ? true : false;
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
            $request = $database->prepare("SELECT createCompany(:first_name, :last_name, :mail, :password, :phone, :social_reason) ;");
            $request->execute($data);
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function validCompany(bool $value, int $id) {
        global $database;
        try {
            $active = ($value) ? 'true' : 'false';
            $request = $database->prepare("UPDATE company SET active = :active WHERE id_company = :id;");
            $request->execute(array('active' => $active, 'id' => $id)); 
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function updateCompany(array $data) {
        global $database;
        try {
            $data_account = array(
                'last_name' => $data['last_name'],
                'first_name' => $data['first_name'],
                'mail' => $data['mail'],
                'phone' => $data['phone'],
                'id' => $data['id']
            );
            self::updateInfoAccount($data_account);

            $data_company = array(
                'social_reason' => $data['social_reason'],
                'active' => $data['active'],
                'id' => $data['id']
            );
            $request = $database->prepare("UPDATE company SET social_reason = :social_reason, active = :active WHERE id_company = :id;");
            $request->execute($data_company); 
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function deleteCompany(int $id) {
        deleteAccount($id);
    }
}

?>