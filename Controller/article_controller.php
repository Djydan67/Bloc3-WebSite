<?php

/**
 * Controller des articles
 */
class Article_Ctrl extends Ctrl
{


    /**
     * Page d'accueil du site
     * @return void
     */
    public function Articles()
    {
        include("Model/article_model.php");
        $objArticleModel    = new Article_model();
        $arrArticles         = $objArticleModel->findAll();
        $this->_arrData['arrArticles']  = $arrArticles;
        $this->_arrData['strPage']        = "article";
        $this->_arrData['strTitleH1']    = "Articles";
        $this->_arrData['strFirstP']    = "Page affichant nos derniers articles";

        $this->display('article_view');
    }
}
