<?php 
// require_once '../Model/StuffModel.php';

// // Vérification de l'existence et de la non-nullité de $_GET['pieces']
// if (isset($_GET['pieces']) && !empty($_GET['pieces'])) {
//     $stuffModel = new StuffModel();
    
//     // Validation de $_GET['pieces'] si nécessaire
//     $pieces = $_GET['pieces']; // Vous pouvez ajouter des validations supplémentaires ici

//     // Appel de la méthode getAmulette avec la valeur de $_GET['pieces']
//     $amulettes = $stuffModel->getAmulette($pieces);
    
//     // Envoi des résultats encodés en JSON
//     header('Content-Type: application/json');
//     echo json_encode($amulettes);
// } else {
//     // Gestion de l'erreur si $_GET['pieces'] est manquant ou vide
//     header('Content-Type: application/json');
//     echo json_encode(['error' => 'ID not provided']);
// }

    class Stuff_Ctrl{

        public function equipements(){
            //var_dump($_GET);
            if(isset($_GET['pieces']) && !empty($_GET['pieces'])) {
                $strPage = "équipements";
                $strTitleH1 = "Bibliothèque";
                $strFirstP = "";
                include("Model/stuff_model.php");
                $objStuffModel = new Stuff_model();
                include("Entities/stuff_entity.php");

                $objStuff = $_GET['pieces'];
                $arrStuff = $objStuffModel->getStuff($objStuff);
                //var_dump($arrStuff);
                //header('Content-Type: application/json');
                json_encode($arrStuff); // Encode les données en JSON
                //exit();
                //
                //return $arrStuff;
            }
            else {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'ID not provided']);
                exit();
            }
            include("View/stuff.php");
        }
    }

?>