<?php

require_once("./ConfDB.inc.php");

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


    public static function getVotes(int $id_article) {
        global $database;
        try {
            $request = $database->prepare("SELECT * FROM vote WHERE id_article = ? ;");
            $request->execute(array($id_article));
            return $request->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function getVote(array $data) {
        global $database;
        try {
            $request = $database->prepare("SELECT * FROM vote WHERE id_account = :id_account AND id_article = :id_article ;");
            $request->execute($data);
            return $request->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function createVote(array $data) {
        global $database;
        try {
            $request = $database->prepare("INSERT INTO vote (id_account, id_article, type) VALUES (:id_account, :id_article, :type_vote);");
            $request->execute($data); 
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function updateVote(array $data) {
        global $database;
        try {
            $request = $database->prepare("UPDATE vote SET type = :type_vote WHERE id_account = :id_account AND id_article = :id_article;");
            $request->execute($data); 
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    public static function deleteVote(array $data) {
        global $database;
        try {
            $request = $database->prepare("DELETE FROM vote WHERE id_account = :id_account AND id_article = :id_article;");
            $request->execute($data);
        } catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }


    public static function getComment(int $data) {
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



    public static function getNbVotes(int $id_article) {
        $result = self::getVotes($id_article);
        $nbPositive = 0;
        $nbNegative = 0;

        foreach($result as $row) {
            if($row->type == 1) $nbPositive++;
            else $nbNegative++;
        }

        return array('total' => $nbPositive + $nbNegative, 'positive' => $nbPositive, 'negative' => $nbNegative);;
    }

    public static function voteFor(int $id_account, int $id_article, string $value) {
        if($value == 'like') $type_vote = "true";
        elseif($value == 'dislike') $type_vote = "false";

        if(isset($type_vote)) {  //The value are 'like' (TRUE) or 'dislike' (FALSE)
            $data1 = array('id_account' => $id_account, 'id_article' => $id_article);
            $data2 = array('id_account' => $id_account, 'id_article' => $id_article, 'type_vote' => $type_vote);
            
            $vote = self::getVote($data1);

            if($vote) { //User already vote for this article
                if( ($vote->type ? "true" : "false" ) == $type_vote) {  //User vote the same thing
                    self::deleteVote($data1);
                }
                else {  //User vote the other possibility
                    self::updateVote($data2);
                }
            }
            else {  //User didn't vote before for this article
                self::createVote($data2);
            }
        }
        else {
            die("ERREUR : type de vote non reconnu");
        }
    }

    public static function getAJAXFunctionsVote(string $id_hash) {
        $like = "vote(this, '$id_hash', 'like')";
        $dislike = "vote(this, '$id_hash', 'dislike')";
        return array('like' => $like, 'dislike' => $dislike);
    }
}

?>