<?php

class Groupe {

    private $Idclasse;
    private $Nom;
    private $bdd;

    //Requête création groupe

    public function __construct($db) {

        this->bdd = $db;
    }

    public function newGroupe() {
        
        //Crea requête
        $query = "INSERT INTO `classe`(`Id`, `Nom`) VALUES (NULL,':Nom')";
        
        //Prepare
        $requete = $this->bdd->prepare($query);

        //link param
        $requete->bindParam(':Nom', $this->Nom);
        
        //exécuter

        if($requete->execute()) {

            return true;
        }
        
        else {return false;}


    }
}



?>