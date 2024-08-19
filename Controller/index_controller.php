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
        $this->display('index_view');
    }
}
