<?php
include("bdd.php");

class Stuff_model extends Bdd
{

    public function getStuff($objStuff)
    {

        $sqlQuery = 'SELECT stuff_name, stuff_imgPath, stuff_level, stuff_setType, stuff_description, stuff_pieces, stuff_imgPathMobile FROM T_stuff WHERE stuff_pieces = :pieceId';

        //Execution de la requete avec la variable sécurisée :pieceId
        $strPrepare = $this->_db->prepare($sqlQuery);
        $strPrepare->bindValue(':pieceId', $objStuff, PDO::PARAM_STR);
        $strPrepare->execute();
        //var_dump($strPrepare);
        //Retourne les amulettes
        return $strPrepare->fetchAll();

        // } catch (PDOException $e) {
        //     //Gestion des erreurs
        //     die('Erreur : ' . $e->getMessage());
        // }
    }

    public function getAfficheStuff()
    {

        $sqlQuery = 'SELECT stuff_name, stuff_imgPath, stuff_level, stuff_setType, stuff_description, stuff_pieces, stuff_imgPathMobile FROM T_stuff';

        //Execution de la requete avec la variable sécurisée :pieceId
        $strPrepare = $this->_db->prepare($sqlQuery);
        $strPrepare->execute();
        //var_dump($strPrepare);
        //Retourne les amulettes
        return $strPrepare->fetchAll();

        // } catch (PDOException $e) {
        //     //Gestion des erreurs
        //     die('Erreur : ' . $e->getMessage());
        // }
    }
}
