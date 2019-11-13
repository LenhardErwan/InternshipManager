<?php

class Comment {
    public static function getComment(array $data) {
        global $database;
        try {
            $request = $database->prepare("SELECT * FROM comment WHERE id_admin = :id_admin AND id_article = :id_article ;");
            $request->execute($data);
            return $request->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function createComment(array $data) {
        global $database;
        try {
            $request = $database->prepare("INSERT INTO comment VALUES (:id_admin, :id_article, :text);");
            $request->execute($data); 
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function updateComment(array $data) {
        global $database;
        try {
            $request = $database->prepare("UPDATE comment SET text = :text WHERE id_admin = :id_admin AND id_article = :id_article;");
            $request->execute($data); 
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function deleteComment(array $id) {
        global $database;
        try {
            $request = $database->prepare("DELETE FROM comment WHERE id_admin = :id_admin AND id_article = :id_article;");
            $request->execute($data);
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }
}

?>