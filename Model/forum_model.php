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
            "   SELECT theme_id, theme_nom, theme_description, theme_update, theme_color
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

    /**
     * Create a new forum.
     * 
     * @param string $titre The title of the forum.
     * @param string $message The message of the forum.
     * @param int $userId The ID of the user creating the forum.
     * @param int $themeId The ID of the theme.
     * @return bool Whether the forum was created successfully.
     */

    public function createForum($titre, $message, $userId, $themeId)
    {
        $strQuery =
            "INSERT INTO T_forum (forum_titre, forum_message, forum_date, forum_isvalide, forum_isclose, user_id, theme_id)
             VALUES (:titre, :message, NOW(), 1, 0, :user_id, :theme_id);";
        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->bindValue(":titre", $titre, PDO::PARAM_STR);
        $strPrepare->bindValue(":message", $message, PDO::PARAM_STR);
        $strPrepare->bindValue(":user_id", $userId, PDO::PARAM_INT);
        $strPrepare->bindValue(":theme_id", $themeId, PDO::PARAM_INT);
        return $strPrepare->execute();
    }
    /**
     * Create a new response for a forum.
     * 
     * @param string $message The message of the response.
     * @param int $userId The ID of the user creating the response.
     * @param int $forumId The ID of the forum.
     * @return bool Whether the response was created successfully.
     */
    public function createResponse($message, $userId, $forumId)
    {
        $strQuery =
            "INSERT INTO T_reponse (reponse_message, reponse_date, user_id, forum_id)
             VALUES (:message, NOW(), :user_id, :forum_id);";
        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->bindValue(":message", $message, PDO::PARAM_STR);
        $strPrepare->bindValue(":user_id", $userId, PDO::PARAM_INT);
        $strPrepare->bindValue(":forum_id", $forumId, PDO::PARAM_INT);
        return $strPrepare->execute();
    }
}
