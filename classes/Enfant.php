<?php

class Enfant {

    public $Id;
    public $Nom;
    public $Prenom;
    public $Annee;
    public $IdClasse;
    private $bdd;


    //Requête création groupe

    public function __construct($db) {
        $this->bdd = $db;
    }

    public function newEnfant() {
        

        //regarde si eleve existe déjà
        $query = "SELECT `Id`, `Nom`, `Prenom`, `Annee`, `IdClasse` FROM `eleve` WHERE Nom = :Nom AND Prenom = :Prenom";

         //Prepare
         $requete = $this->bdd->prepare($query);
         $this->Nom=htmlspecialchars(strip_tags($this->Nom));
         $this->Prenom=htmlspecialchars(strip_tags($this->Prenom));
         $this->Annee=htmlspecialchars(strip_tags($this->Annee));
         $this->IdClasse=htmlspecialchars(strip_tags($this->IdClasse));
         //link param
         $requete->bindParam(':Nom', $this->Nom);
         $requete->bindParam(':Prenom', $this->Prenom);

         $requete->execute();

         $search = $requete->fetch();
         if($search != null) {
            
            return false;
         }
         else {

        //Crea requête
        $query = "INSERT INTO eleve (Nom, Prenom, Annee, IdClasse) VALUES (:Nom,:Prenom,:Annee,:IdClasse)";

        //Prepare
        $requete = $this->bdd->prepare($query);
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
}

?>