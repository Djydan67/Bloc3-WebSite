<?php
include("bdd.php");

class Stuff_model extends Bdd
{
    /**
     * Récupère les données de la table T_stuff
     */
    public function getAfficheStuff()
    {

        $sqlQuery = 'SELECT stuff_name, stuff_imgPath, stuff_level, stuff_setType, stuff_description, stuff_pieces, stuff_imgPathMobile FROM T_stuff';

        $strPrepare = $this->_db->prepare($sqlQuery);
        $strPrepare->execute();
        return $strPrepare->fetchAll();
    }
}
