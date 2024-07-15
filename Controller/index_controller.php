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

        $this->_arrData['strPage']        = "index";
        $this->_arrData['strTitleH1']    = "Accueil";
        $this->_arrData['strFirstP']    = "Page affichant les 4 derniers articles";

        $this->display('index_view');
    }
}
