<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class StuffModel {

    public function getStuffs() {
        //Connexion à la base de données
        try 
        {
            $mysqlClient = new PDO(
                'mysql:host=localhost;dbname=u751308929_dofus;charset=utf8',
                'u751308929_root',
                'Doomsday4ever!'
            );
            echo "Connexion à la BDD réussie";
            //Requete SQL
            $sqlQuery = 'SELECT * FROM equipements';

            //Execution de la requete
            $stuff1 = $mysqlClient->prepare($sqlQuery);
            $stuff1 ->execute();
            
            echo "Requete réussi";
            
            //Récupération des résultats
            $stuff = $stuff1->fetchAll(PDO::FETCH_ASSOC);
            
            echo "Données récupérées";
            
            foreach ($stuff as $item) {
                echo "<p>" . $item['name'] . "</p>";
            }
            //Retourne equipements
            return $stuff;
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
    }
    
}