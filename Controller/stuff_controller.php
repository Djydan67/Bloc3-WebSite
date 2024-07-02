<?php
 /**
  * Controller de tous les équipements
  * @author Renaud 
  */

class Stuff_Ctrl extends Ctrl
{

    public function equipements()
    {
        //var_dump($_GET);
        if (isset($_GET['pieces']) && !empty($_GET['pieces'])) {
            $strPage = "équipements";
            $strTitleH1 = "Bibliothèque";
            $strFirstP = "";
            include("Model/stuff_model.php");
            $objStuffModel = new Stuff_model();
            include("Entities/stuff_entity.php");

            $objStuff = $_GET['pieces'];
            $arrStuff = $objStuffModel->getStuff($objStuff);
            //var_dump($arrStuff);
            header('Content-Type: application/json');
            echo json_encode($arrStuff); // Encode les données en JSON
            //exit();
            //
            //return $arrStuff;
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'ID not provided']);
            exit();
        }
        //include("View/stuff.php");
    }

    /**
     * Page de la bibliothèque d'équipements
     */
    public function tousEquipements()
    {
        // $strPage = "équipements";
        // $strTitleH1 = "Bibliothèque";
        // $strFirstP = "";
        // include("Model/stuff_model.php");
        // $objStuffModel = new Stuff_model();
        // include("Entities/stuff_entity.php");

        // $arrStuff = $objStuffModel->getAfficheStuff();
        // header('Content-Type: application/json');
        // echo json_encode($arrStuff);
        // include("Model/stuff_model.php");
        // $objStuffModel = new Stuff_model();
        // $arrStuff = $objStuffModel->getAfficheStuff();
        // $this->_arrData['arrStuff'] = $arrStuff;

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
