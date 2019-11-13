<?php

class Article {
    public static function getArticle(string $hash) {
        global $database;
        try {
            $request = $database->prepare("SELECT * FROM article WHERE id_hash = ? ;");
            $request->execute(array($hash)); 
            return $request->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function createArticle(array $data) {
        global $database;
        try {
            $request = $database->prepare("INSERT INTO article (id_company, id_hash, title, begin_date, end_date, mission, contact, attachement) VALUES(:id_company, :id_hash, :title, :begin_date, :end_date, :mission, :contact, :attachement);");
            $request->execute($data); 
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function updateArticle(array $data) {
        global $database;
        try {
            $request = $database->prepare("UPDATE article SET title = :title, begin_date = :begin_date, end_date = :end_date, mission = :mission, attachement = :attachement WHERE id_article = :id_article;");
            $request->execute($data); 
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function deleteArticle(int $id) {
        global $database;
        try {
            $request = $database->prepare("DELETE FROM article WHERE id_article = ?;");
            $request->execute($id); 
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }
}

?>