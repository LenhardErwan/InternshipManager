<?php
    include_once("ConfDB.inc.php");

    function getAccount(string $mail) {
        $request = $DB->prepare("SELECT * FROM account A WHERE mail=? ;");
        $request->execute(array($mail)); 
        return $request->fetch(PDO::FETCH_OBJ);
    }

    function createAccount(array $data) {
        $request = $DB->prepare("INSERT INTO account (first_name, last_name, mail, password, phone) VALUES (:first_name, :last_name, :mail, :password, :phone);");
        $request->execute($data); 
    }

    function updateAccount(array $data) {
        $request = $DB->prepare("UPDATE account SET first_name = :first_name, last_name = :last_name, mail = :mail, password = :password, phone = :phone WHERE id_account = :id;");
        $request->execute($data); 
    }

    function deleteAccount(int $id) {
        $request = $DB->prepare("DELETE FROM account WHERE id_account = ?;");
        $request->execute($id); 
    }


    function getMember(string $mail) {
        $request = $DB->prepare("SELECT * FROM account A JOIN member M ON A.id_account=M.id_member WHERE mail=? ;");
        $request->execute(array($mail)); 
        return $request->fetch(PDO::FETCH_OBJ);
    }

    function createMember(array $data) {
        $request = $DB->prepare("SELECT createMember(:first_name, :last_name, :mail, :password, :phone, :birth_date, :degrees ;");
        $request->execute($data);
    }

    function updateMember(array $data) {
        updateAccount($data);
        $request = $DB->prepare("UPDATE member SET birth_date = :birth_date, degrees = :degrees WHERE id_member = :id;");
        $request->execute($data); 
    }

    function deleteMember(int $id) {
        deleteAccount($id);
    }


    function getCompany(string $mail) {
        $request = $DB->prepare("SELECT * FROM account A JOIN company C ON A.i=C.id_company WHERE mail=? ;");
        $request->execute(array($mail)); 
        return $request->fetch(PDO::FETCH_OBJ);
    }

    function createCompany(array $data) {
        $request = $DB->prepare("SELECT createCompany(:first_name, :last_name, :mail, :password, :phone, :social_reason, :degrees ;");
        $request->execute($data);
    }

    function updateCompany(array $data) {
        updateAccount($data);
        $request = $DB->prepare("UPDATE company SET social_reason = :social_reason, active = :active WHERE id_company = :id;");
        $request->execute($data); 
    }

    function deleteCompany(int $id) {
        deleteAccount($id);
    }


    function getArticle(string $hash) {
        $request = $DB->prepare("SELECT * FROM article WHERE id_hash = ? ;");
        $request->execute(array($hash)); 
        return $request->fetch(PDO::FETCH_OBJ);
    }

    function createArticle(array $data) {
        $request = $DB->prepare("INSERT INTO article (id_company, id_hash, title, begin_date, end_date, mission, contact, attachement) VALUES(:id_company, :id_hash, :title, :begin_date, :end_date, :mission, :contact, :attachement);");
        $request->execute($data); 
    }

    function updateArticle(array $data) {
        $request = $DB->prepare("UPDATE article SET title = :title, begin_date = :begin_date, end_date = :end_date, mission = :mission, attachement = :attachement WHERE id_article = :id_article;");
        $request->execute($data); 
    }

    function deleteArticle(int $id) {
        $request = $DB->prepare("DELETE FROM article WHERE id_article = ?;");
        $request->execute($id); 
    }


    function getVotes(int $id_article) {
        $request = $DB->prepare("SELECT * FROM vote WHERE id_article = ? ;");
        $request->execute(array($id_article));
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    function getVote(array $data) {
        $request = $DB->prepare("SELECT * FROM vote WHERE id_account = :id_account AND id_article = :id_article ;");
        $request->execute($data);
        return $request->fetch(PDO::FETCH_OBJ);
    }

    function createVote(array $data) {
        $request = $DB->prepare("INSERT INTO vote (id_account, id_article, positive) VALUES (:id_account, :id_article, :vote);");
        $request->execute($data); 
    }

    function updateVote(array $data) {
        $request = $DB->prepare("UPDATE vote SET positive = :vote WHERE id_account = :id_account AND id_article = :id_article;");
        $request->execute($data); 
    }

    function deleteVote(array $data) {
        $request = $DB->prepare("DELETE FROM vote WHERE id_account = :id_account AND id_article = :id_article;");
        $request->execute($data);
    }


    function getComment(array $data) {
        $request = $DB->prepare("SELECT * FROM comment WHERE id_admin = :id_admin AND id_article = :id_article ;");
        $request->execute($data);
        return $request->fetch(PDO::FETCH_OBJ);
    }

    function createComment(array $data) {
        $request = $DB->prepare("INSERT INTO comment VALUES (:id_admin, :id_article, :text);");
        $request->execute($data); 
    }

    function updateComment(array $data) {
        $request = $DB->prepare("UPDATE comment SET text = :text WHERE id_admin = :id_admin AND id_article = :id_article;");
        $request->execute($data); 
    }

    function deleteComment(array $id) {
        $request = $DB->prepare("DELETE FROM comment WHERE id_admin = :id_admin AND id_article = :id_article;");
        $request->execute($data);
    }
?>