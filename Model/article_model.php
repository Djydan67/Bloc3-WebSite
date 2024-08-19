<?php
include("bdd.php");

class Article_model extends Bdd
{

    public function findAll()
    {
        // Faire la requête
        $strQuery        = "SELECT 
        T_article.article_id, 
        T_article.article_titre,
        T_article.article_message, 
        T_article.article_ImgID, 
        T_article.article_datecreation, 
        T_user.user_id 
    FROM 
        T_article
    INNER JOIN 
        T_user 
    ON 
        T_article.user_id = T_user.user_id 
    ORDER BY 
        T_article.article_datecreation DESC 
    LIMIT 4;";
        return $this->_db->query($strQuery)->fetchAll();
    }
}
class News_model extends Bdd
{
    public function findNews($articleId = null)
    {
        if ($articleId) {
            // Requête pour un article spécifique
            $query = "SELECT * FROM T_article WHERE article_id = :id";
            $stmt = $this->_db->prepare($query);
            $stmt->bindParam(':id', $articleId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC); // Utilisez fetch pour un seul résultat
        } else {
            // Requête pour tous les articles
            $query = "SELECT * FROM T_article";
            $stmt = $this->_db->query($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $result;
    }
}
class Index_model extends Bdd
{

    public function findAll()
    {
        // Faire la requête
        $strQuery        = "SELECT 
        T_article.article_id, 
        T_article.article_titre,
        T_article.article_message, 
        T_article.article_ImgID, 
        T_article.article_datecreation, 
        T_user.user_id 
    FROM 
        T_article
    INNER JOIN 
        T_user 
    ON 
        T_article.user_id = T_user.user_id 
    ORDER BY 
        T_article.article_datecreation DESC 
    LIMIT 1;";
        return $this->_db->query($strQuery)->fetchAll();
    }
}
