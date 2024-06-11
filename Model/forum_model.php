<?php 
    /**
     * Forum Model
     * @author Salar
     */

    include("bdd.php");

    class Forum_model extends Bdd {

        public function getAllByTheme($objForum){
            // SQL request to select the messages of a specific theme
            $strQuery = 
                "   SELECT forum_titre, forum_message, forum_date, forum_isvalide, forum_isclose, fo.user_id
                    FROM T_forum fo 
                    INNER JOIN T_user us ON us.user_id = fo.user_id 
                    WHERE theme_id = :theme;
                ";
            $strPrepare = $this->_db->prepare($strQuery);
            $strPrepare->bindValue(":theme", $objForum, PDO::PARAM_STR);
            $strPrepare->execute();
            return $strPrepare->fetchAll(PDO::FETCH_ASSOC);
        }
    }