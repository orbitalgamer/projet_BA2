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
}



?>