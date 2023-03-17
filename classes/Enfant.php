<?php

class Enfant {

    public $Id;
    public $Nom;
    private $Prenom;
    private $Annee;
    private $IdClasse;
    private $bdd;


    //Requête création groupe

    public function __construct($db) {
        $this->bdd = $db;
    }

    public function newEnfant() {
        
        //Crea requête
        $query = INSERT INTO `eleve`(`Nom`, `Prenom`, `Annee`, `IdClasse`) VALUES (':Nom',':Prenom',':Annee',':IdClasse')
        
        //Prepare
        $requete = $this->bdd->prepare($query);
        $this->Nom=htmlspecialchars(strip_tags($this->Nom));
        //link param
        $requete->bindParam(':Nom', $this->Nom);
        $requete->bindParam(':Prenom', $this->Prenom);
        $requete->bindParam(':Annee', $this->Annee);
        $requete->bindParam(':IdClasse', $this->IdClasse);
        //var_dump($requete);
        
        //exécuter

        if($requete->execute()) {

            return true;
        }
        
        else {return false;}


    }
}

?>