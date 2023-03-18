<?php

class Groupe {

    public $Idclasse;
    public $Nom;
    private $bdd;

    //Requête création groupe

    public function __construct($db) {
        $this->bdd = $db;
    }

    public function newGroupe() {
        
        //Crea requête
        $query = "INSERT INTO classe (Nom) VALUES(:Nom)";
        
        //Prepare
        $requete = $this->bdd->prepare($query);
        $this->Nom=htmlspecialchars(strip_tags($this->Nom));
        //link param
        $requete->bindParam(':Nom', $this->Nom);
        //var_dump($requete);
        
        //exécuter

        if($requete->execute()) {

            return true;
        }
        
        else {return false;}


    }

    public function modifGroupe() {

        //Crea requête

        $query = "UPDATE classe SET Nom=:Nom WHERE Id = :Id";

        //Prepare
        $requete = $this->bdd->prepare($query);
        $this->Nom=htmlspecialchars(strip_tags($this->Nom));
        $this->Id=htmlspecialchars(strip_tags($this->Id));
        //link param
        $requete->bindParam(':Nom', $this->Nom);
        $requete->bindParam(':Id', $this->Id);


        if($requete->execute()) {

            return true;
        }
        
        else {return false;}

    }
}



?>