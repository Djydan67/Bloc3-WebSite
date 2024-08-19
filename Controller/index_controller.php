<?php

/**
 * Controller de la page d'accueil
 * @author Renaud
 */
class Index_Ctrl extends Ctrl
{


    /**
     * Page d'accueil du site
     * @return void
     */
    public function index()
    {
        include("Model/article_model.php");
        $objArticleModel    = new Index_model();
        $arrArticles         = $objArticleModel->findAll();
        $this->_arrData['arrArticles']  = $arrArticles;
        $this->_arrData['strPage']        = "index";
        $this->_arrData['strTitleH1']    = "Accueil";
        $this->_arrData['strFirstP']    = "Page affichant l'accueil du site";

        $this->display('index_view');
    }
}
