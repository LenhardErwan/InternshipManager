<?php 
    function vote(int $id_account, int $id_article, bool $value) {
        global $DB;
        try {
            $prepare = $DB->prepare("INSERT INTO vote (id_user, id_article, positive) VALUES (:id_account, :id_article, :value);");
            $prepare->execute(array('id_account' => $id_account, 'id_article' => $id_article, 'value' => $value));    
        }
        catch (Execption $e) {
            die("ERREUR : ".$e);
        }
   }

    function getVote(int $id_article) {
        global $DB;
        $nbPositive = 0;
        $nbNegative = 0;

        try {
            $prepare = $DB->prepare("SELECT positive FROM vote WHERE id_article=?");
            $prepare->execute(array($id_article));    
        }
        catch (Execption $e) {
            die("ERREUR : ".$e);
        }

        while($line = $prepare->fetch(PDO::FETCH_OBJ)) {
            if($line->positive == 1) $nbPositive++;
            else $nbNegative++;
        }

        $result = '<div class="vote">'."\n";
        $result .= '<div><button class="like">like</button><span>'.$nbPositive.'</span></div>'."\n";
        $result .= '<div><button class="dislike">dislike</button><span>'.$nbNegative.'</span></div>'."\n";
        $result .= '</div>'."\n";

        return $result;
    }

?>