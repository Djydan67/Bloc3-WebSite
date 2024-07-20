<?php 

class StuffController {

        public function afficherStuffs() {
            //Instancier le modèle
            require_once 'Model/StuffModel.php';
            $stuffModel = new StuffModel();

            //Récupérer les équipements depuis le modèle
            $stuffs = $stuffModel->getStuffs();

            //Envoie les données au format JSON
            header('Content-Type: application/json');
            echo json_encode($stuffs);
        }
}