<?php
class Bdd
{

	protected $_db;

	public function __construct()
	{
		try {
			// Connexion à la base de données
			$this->_db = new PDO(
				"mysql:host=193.203.168.48;dbname=u751308929_dofus",  // Serveur et BDD
				"u751308929_root",  		//Nom d'utilisateur de la base de données
				"Doomsday4ever!",	 	// Mot de passe de la base de données
				array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC) // Mode de renvoi 
			);
			// Pour résoudre les problèmes d’encodage
			$this->_db->exec("SET CHARACTER SET utf8");
			// Configuration des exceptions
			$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo "Échec : " . $e->getMessage();
		}
	}

	protected function execute_requete($strRq)
	{
		try {
			// echo "<pre>";
			// var_dump($strRq->debugDumpParams());
			$strRq->execute();
			return $strRq;
		} catch (PDOException $e) {
			$_SESSION['error']  = var_dump($e->getMessage());//"Erreur - Veuillez contacter l'administrateur";
			return false;
		}
	}
}
