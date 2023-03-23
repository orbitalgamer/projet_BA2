<?php



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


}



?>