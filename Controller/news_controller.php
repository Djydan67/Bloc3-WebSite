<?php

/**
 * Controller des articles
 */
class News_Ctrl extends Ctrl
{
    public function news()
    {
        include('model/article_model.php');
        $newsModel = new News_model();

        // Récupérer l'ID de l'article depuis l'URL
        $articleId = isset($_GET['id']) ? (int)$_GET['id'] : null;

        // Récupérer les détails de l'article
        $arrArticle = $newsModel->findNews($articleId);

        // Vérifier si l'article a été trouvé
        if ($arrArticle) {
            $this->_arrData['arrNews']  = $arrArticle; // Attribuez directement le tableau associatif retourné
            $this->_arrData['strPage']  = "news";
            $this->_arrData['strTitleH1'] = $arrArticle['article_titre'];
            $this->_arrData['strFirstP'] = "Page affichant les détails de l'article sélectionné";
        } else {
            // Gérer le cas où l'article n'est pas trouvé
            $this->_arrData['strPage']  = "news";
            $this->_arrData['strTitleH1'] = "Article non trouvé";
            $this->_arrData['strFirstP'] = "L'article demandé n'existe pas.";
        }

        // Afficher la vue
        $this->display('news_view');
    }
}
