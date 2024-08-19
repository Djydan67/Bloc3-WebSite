<?php

/**
 * Forum Model
 * 
 * This class handles interactions with the forum and theme database tables.
 * 
 * @autor Salar
 */

include("bdd.php");

class Forum_model extends Bdd
{
    /**
     * Retrieve all forums by a specific theme with pagination.
     * 
     * @param int $themeId The ID of the theme.
     * @param int $limit The number of forums to return.
     * @param int $page The page number to return.
     * @return array The list of forums associated with the theme and pagination details.
     */
    public function getAllForumsByTheme($themeId, $limit = 0)
    {
        // Adjust the SQL query depending on whether a limit is set or not
        $strQuery = "
             SELECT 
                 fo.forum_id, 
                 fo.forum_titre, 
                 fo.forum_message, 
                 fo.forum_date, 
                 fo.forum_isvalide, 
                 fo.forum_isclose, 
                 fo.user_id,
                 us.user_pseudo  -- Select the user_pseudo from T_user
             FROM T_forum fo 
             INNER JOIN T_user us ON us.user_id = fo.user_id 
             WHERE fo.theme_id = :theme AND fo.forum_isclose = 0
        ";

        if ($limit > 0) {
            $strQuery .= " LIMIT :limit";
        }

        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->bindValue(":theme", $themeId, PDO::PARAM_INT);

        if ($limit > 0) {
            $strPrepare->bindValue(":limit", $limit, PDO::PARAM_INT);
        }

        $strPrepare->execute();
        $forums = $strPrepare->fetchAll(PDO::FETCH_ASSOC);

        return [
            'forums' => $forums
        ];
    }

    /**
     * Retrieve all themes.
     * 
     * @return array The list of themes.
     */
    public function getAllThemes()
    {
        $strQuery = "
             SELECT theme_id, theme_nom, theme_description, theme_update, theme_color, theme_isActive
             FROM T_theme where theme_isActive = 1;
         ";
        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->execute();
        return $strPrepare->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getForumResponses($forumId)
    {
        $strQuery = "
             SELECT 
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
        $strQuery = "
             INSERT INTO T_forum (forum_titre, forum_message, forum_date, forum_isvalide, forum_isclose, user_id, theme_id)
             VALUES (:titre, :message, NOW(), 1, 0, :user_id, :theme_id);
         ";
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
        $strQuery = "
             INSERT INTO T_reponse (reponse_message, reponse_date, user_id, forum_id)
             VALUES (:message, NOW(), :user_id, :forum_id);
         ";
        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->bindValue(":message", $message, PDO::PARAM_STR);
        $strPrepare->bindValue(":user_id", $userId, PDO::PARAM_INT);
        $strPrepare->bindValue(":forum_id", $forumId, PDO::PARAM_INT);
        return $strPrepare->execute();
    }

    public function closeForum($forumId)
    {
        $strQuery = "
             UPDATE T_forum
             SET forum_isclose = 1
             WHERE forum_id = :forum_id;
         ";
        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->bindValue(":forum_id", $forumId, PDO::PARAM_INT);
        return $strPrepare->execute();
    }

    public function openForum($forumId)
    {
        $strQuery = "
             UPDATE T_forum
             SET forum_isclose = 0
             WHERE forum_id = :forum_id;
         ";
        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->bindValue(":forum_id", $forumId, PDO::PARAM_INT);
        return $strPrepare->execute();
    }

    public function validateForum($forumId)
    {
        $strQuery = "
             UPDATE T_forum
             SET forum_isvalide = 1
             WHERE forum_id = :forum_id;
         ";
        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->bindValue(":forum_id", $forumId, PDO::PARAM_INT);
        return $strPrepare->execute();
    }

    public function invalidateForum($forumId)
    {
        $strQuery = "
             UPDATE T_forum
             SET forum_isvalide = 0
             WHERE forum_id = :forum_id;
         ";
        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->bindValue(":forum_id", $forumId, PDO::PARAM_INT);
        return $strPrepare->execute();
    }

    public function deleteForum($forumId)
    {
        $strQuery = "
             UPDATE T_forum
             SET forum_isClose = 1
             WHERE forum_id = :forum_id;
         ";
        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->bindValue(":forum_id", $forumId, PDO::PARAM_INT);
        return $strPrepare->execute();
    }

    public function deleteResponse($responseId)
    {
        $strQuery = "
             DELETE FROM T_reponse
             WHERE reponse_id = :reponse_id;
         ";
        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->bindValue(":reponse_id", $responseId, PDO::PARAM_INT);
        return $strPrepare->execute();
    }

    public function createTheme($nom, $description, $color)
    {
        $strQuery = "
             INSERT INTO T_theme (theme_nom, theme_description, theme_update, theme_color)
             VALUES (:nom, :description, NOW(), :color);
         ";
        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->bindValue(":nom", $nom, PDO::PARAM_STR);
        $strPrepare->bindValue(":description", $description, PDO::PARAM_STR);
        $strPrepare->bindValue(":color", $color, PDO::PARAM_STR);
        return $strPrepare->execute();
    }

    public function updateTheme($themeId, $nom, $description, $color)
    {
        $strQuery = "
             UPDATE T_theme
             SET theme_nom = :nom, theme_description = :description, theme_update = NOW(), theme_color = :color
             WHERE theme_id = :theme_id;
         ";
        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->bindValue(":theme_id", $themeId, PDO::PARAM_INT);
        $strPrepare->bindValue(":nom", $nom, PDO::PARAM_STR);
        $strPrepare->bindValue(":description", $description, PDO::PARAM_STR);
        $strPrepare->bindValue(":color", $color, PDO::PARAM_STR);
        return $strPrepare->execute();
    }

    public function deleteTheme($themeId)
    {
        $strQuery = "
             UPDATE T_theme
             SET theme_isActive = 0
             WHERE theme_id = :theme_id;
         ";
        $strPrepare = $this->_db->prepare($strQuery);
        $strPrepare->bindValue(":theme_id", $themeId, PDO::PARAM_INT);
        return $strPrepare->execute();
    }
}
