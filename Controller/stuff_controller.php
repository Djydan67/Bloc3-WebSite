<?php

/**
 * Controller de tous les équipements
 * @author Renaud 
 */

class Stuff_Ctrl extends Ctrl
{
    /**
     * Page de la bibliothèque d'équipements
     */
    public function tousEquipements()
    {
        $this->_arrData['strPage'] = "stuff";
        $this->_arrData['strTitleH1'] = "Bibliothèque";
        $this->_arrData['strFirstP'] = "";

        $this->display('stuff');
    }

    /**
     * recupère les données et les converties en json
     */
    public function getEquipementsJson()
    {
        include("Model/stuff_model.php");
        $objStuffModel = new Stuff_model();
        $arrStuff = $objStuffModel->getAfficheStuff();
        header('Content-Type: application/json');
        echo json_encode($arrStuff);
        exit();
    }
}
