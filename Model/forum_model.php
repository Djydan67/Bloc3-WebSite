<?php

/**
 * Forum Model
 * 
 * This class handles interactions with the forum and theme database tables.
 * 
 * @author Salar
 */

include("bdd.php");

class Forum_model extends Bdd
{

    /**
     * Retrieve all forums by a specific theme.
     * 
     * @param int $themeId The ID of the theme.
     * @return array The list of forums associated with the theme.
     */
    public function getAllForumsByTheme($themeId)
    {
        // SQL query to select the messages of a specific theme
        $strQuery =
            "   SELECT forum_id, forum_titre, forum_message, forum_date, forum_isvalide, forum_isclose, fo.user_id
                    FROM T_forum fo 
                    INNER JOIN T_user us ON us.user_id = fo.user_id 
                    WHERE theme_id = :theme;
            ";
        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->bindValue(":theme", $themeId, PDO::PARAM_INT);
        $strPrepare->execute();
        return $strPrepare->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieve all themes.
     * 
     * @return array The list of themes.
     */
    public function getAllThemes()
    {
        $strQuery =
            "   SELECT theme_id, theme_nom, theme_description, theme_update
                    FROM T_theme;
                ";
        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->execute();
        return $strPrepare->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getForumResponses($forumId)
    {
        $strQuery =
            "   SELECT 
                r.reponse_id, 
                r.reponse_message, 
                r.user_id, 
                r.reponse_date,
                u.user_pseudo
            FROM 
                T_reponse r
            INNER JOIN 
                T_forum f ON r.forum_id = f.forum_id
            INNER JOIN 
                T_user u ON r.user_id = u.user_id
            WHERE 
                r.forum_id = :forum;
        ";
        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->bindValue(":forum", $forumId, PDO::PARAM_INT);
        $strPrepare->execute();
        return $strPrepare->fetchAll(PDO::FETCH_ASSOC);
    }
}
