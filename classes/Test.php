<?php

require_once 'Auth.php'; //pour vérifier que connecté
class Test{

    public $Id;
    public $IdProf;
    public $IdEleve;
    public $ScoreTDA;
    public $ScoreDyslexie;
    public $ScoreDysortho;
    private $bdd;

    public function __construct($db) {
        $this->bdd = $db;
    }


    public function creaTest() {
        /*
        condition :
            prof peut créer test pour l'enfant qu'il a
            amdin peut créer test pour enfant qu'il n'a pas

            pour vérifier enfant, faire requète d'enfant car compliqué
        */

        $query = "SELECT Nom,Prenom FROM eleve WHERE Id=:IdEleve";
        //preparer
        $requete = $this->bdd->prepare($query);
        $this->IdEleve=strtolower(htmlspecialchars(strip_tags($this->IdEleve)));
        //link param
        $requete->bindParam(':IdEleve', $this->IdEleve);    
       
        $requete->execute();

        $rep=$requete->fetch();

        if($rep != null){
          //Crea requete

          $query = "INSERT INTO test (IdProf, IdEleve, ScoreTDA, ScoreDyslexie, ScoreDysortho) 
          VALUES (:IdProf, :IdEleve, :ScoreTDA, :ScoreDyslexie, :ScoreDysortho)";

          //prepare
          $requete = $this->bdd->prepare($query); 
          $requete->bindParam(':IdProf', $this->IdProf);
          $requete->bindParam(':IdEleve', $this->IdEleve);
          $requete->bindParam(':ScoreTDA', $this->ScoreTDA);
          $requete->bindParam(':ScoreDyslexie', $this->ScoreDyslexie);
          $requete->bindParam(':ScoreDysortho', $this->ScoreDysortho);
        
          //exécuter

          if($requete->execute()) {

              return array();
          }
          //gestion erreur
          else {
              return array('error'=>'param invalide');
          }
        }

        else {
            return array('error'=>'cet eleve n existe pas');
        }





    }


/*
pour affichage condition :
faut que le prof à fait le test même si plus l'enfant

admin doit tout voir

prof peut également voir si d'autre personne ont des doute sur l'enfant s'il l'a encore

décomposer ça plusieur fonction
1 pour une ligne si pour le prof ou pas
*/

    public function recupTest($IdTest) {  // Si on retourne l'Id du test
        

        $perm = false;  // booléen pour check si la personne a l'autorisation

        if(isset($_SESSION['Id'])) {

            if(isset($_SESSION['Admin']) && $_SESSION['Admin'] = true) {

                $perm = true;
            }

        }

            $query = "SELECT `Id`, `IdProf`, `IdEleve`, `Date`, `ScoreTDA`, `ScoreDyslexie`, `ScoreDysortho` FROM `test` WHERE Id = :Id";

             //Prepare
             $requete = $this->bdd->prepare($query);
             $this->Id=htmlspecialchars(strip_tags($this->Id));

             //link param
             $requete->bindParam(':Id', $IdTest);

             $requete->execute();
             $rep = $requete->fetch();

             if($rep == NULL) {

                return array('error'=>'pas trouve');
             }

             else {

                $retour = array();
                $retour ['data'] = $rep;

                return $retour;

             }


        else {

            return array('error'=>'pas perm');
        }



       
    }

    public function recupEnfant($IdEnfant) {  // Si on retourne l'Id de l'élève

        
        $perm = false;  // booléen pour check si la personne a l'autorisation

        if(isset($_SESSION['Id'])) {

            if(isset($_SESSION['Admin']) && $_SESSION['Admin'] = true) {

                $perm = true;
            }
        }


            $query = "SELECT `Id`, `IdProf`, `IdEleve`, `Date`, `ScoreTDA`, `ScoreDyslexie`, `ScoreDysortho` FROM `test` WHERE IdEleve = :IdEleve";

             //Prepare
             $requete = $this->bdd->prepare($query);
             $this->IdEleve=htmlspecialchars(strip_tags($this->IdEleve));

             //link param
             $requete->bindParam(':IdEleve', $IdEnfant);

             $requete->execute();
             $rep = $requete->fetch();

             if($rep == NULL) {

                return array('error'=>'pas trouve');
             }

             else {

                $retour = array();
                $retour ['data'] = $rep;

                return $retour;

             }

        else {

            return array('error'=>'pas perm');
        }



    }





}



?>