<?php 
    // Salar
    // Model Forum

    include("bdd.php");

    class Forum_model extends Bdd {

        public function getbyTheme($objForum){
            // SQL request to select the messages of a specific theme
            $strQuery = 
                "   SELECT forum_titre, forum_message, forum_date, forum_isvalid, forum_isclose, fo.user_id
                    FROM T_forum fo 
                    INNER JOIN T_user us ON us.user_id = fo.user_id 
                    WHERE them_id = :theme;
                ";
            $strPrepare = $this->_db->prepare($strQuery);
            $strPrepare->bindvalue(":theme", $objForum, PDO::PARAM_STR);
            return $this->execute_requete($strPrepare);
        }
    }