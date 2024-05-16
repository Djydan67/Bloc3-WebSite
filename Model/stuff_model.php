<?php
    include("bdd.php");

class Stuff_model extends Bdd {

    public function getStuff($objStuff) {
        
            $sqlQuery = 'SELECT stuff_name, stuff_imgPath, stuff_level, stuff_setType, stuff_description, stuff_pieces FROM T_stuff WHERE stuff_pieces = :pieceId';
    
            //Execution de la requete avec la variable sécurisée :pieceId
            $strPrepare = $this->_db->prepare($sqlQuery);
            $strPrepare->bindValue(':pieceId', $objStuff, PDO::PARAM_STR);
            return $this->execute_requete($strPrepare);
            //var_dump($sqlQuery);
            //Retourne les amulettes
            return $this->_db->query($sqlQuery)->fetchAll();

        // } catch (PDOException $e) {
        //     //Gestion des erreurs
        //     die('Erreur : ' . $e->getMessage());
        // }
    }
}