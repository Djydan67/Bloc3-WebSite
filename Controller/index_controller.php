<?php

/**
 * Controller de la page d'accueil
 * @author Renaud
 */
    class Index_Ctrl extends Ctrl{


        /**
         * Page d'accueil du site
         * @return void
         */
        public function index (){
            /*$strPage	= "index";
            $strTitleH1	= "Accueil";
            $strFirstP	= "Page affichant les 4 derniers articles";
            include("_partial/header.php");
            // Utilisation du modèle
            include("models/article_model.php");
            $objArticleModel	= new Article_model();
            $arrArticles 		= $objArticleModel->findAll();

            // J'affiche la vue
            include("views/index_view.php");

            include("_partial/footer.php");
            */

            //include("models/article_model.php");
            //$objArticleModel	= new Article_model();
            //$arrArticles 		= $objArticleModel->findAll();
            //$this->_arrData['arrArticles']  = $arrArticles;

            $this->_arrData['strPage']	    = "index";
            $this->_arrData['strTitleH1']	= "Accueil";
            $this->_arrData['strFirstP']	= "Page affichant les 4 derniers articles";

            $this->display('index_view');
        }
    }