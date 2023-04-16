<?php

include_once 'Auth.php'; //pour vérifier que connecté
require_once 'Enfant.php'; //pour pouvoir utilise de requète tout faite d'enfant
require_once 'Enseignant.php'; //pour utiliser des requète de prof

class Test{

    public $Id;
    public $IdProf;
    public $IdEleve;
    public $ScoreTDA;
    public $ScoreDyslexie;
    public $ScoreDysortho;
    private $bdd;

    public function __construct($db, $Token) {
        $this->bdd = $db;

        $auth = New Auth($db); //créer objet auth
        $reponse = $auth->VerifConnection($Token); //verifie si connecté
        if(!isset($reponse['error'])){ //remets en variable session pour leur requète qui plante
            $_SESSION['Id']=$reponse['Id'];
            $_SESSION['Admin']=$reponse['Admin'];
        }
    }


    public function Create() {
        /*
        condition :
            prof peut créer test pour l'enfant qu'il a
            amdin peut créer test pour enfant qu'il n'a pas

            pour vérifier enfant, faire requète d'enfant car compliqué

            fonctionnement : recherche sur eleve avec fonction et renvoie déjà ces élève si admin ou pas
        */
        if(isset($_SESSION['Id'])){//vérifie si connceté
                //commence par vérifier si élève existe + que prof y a accès
                $Enfant = new Enfant($this->bdd, 'osef pas besoin token, car session');

                //récupère Id
                $this->IdEleve=strtolower(htmlspecialchars(strip_tags($this->IdEleve)));
                $rep = $Enfant->SelectionnerEnfant($this->IdEleve); //faire requète pour vérifier si enfant existe par rapport à ce qu'on a déjà fait avant #vivelerecyclage
                
                if(!isset($rep['error'])){ //si pas erreur

                    //vérifeir qu'existe pas exactement le même test déjà
                    $query="SELECT Id FROM test WHERE IdProf=:IdProf AND IdEleve=:IdEleve AND ScoreTDA=:ScoreTDA AND ScoreDyslexie=:ScoreDyslexie AND ScoreDysortho=:ScoreDysortho";

                    //prépare
                    $requete = $this->bdd->prepare($query);

                    //mets param
                    $requete->bindParam(':IdProf', $_SESSION['Id']);
                    $requete->bindParam(':IdEleve', $this->IdEleve);
                    $requete->bindParam(':ScoreTDA', $this->ScoreTDA);
                    $requete->bindParam(':ScoreDyslexie', $this->ScoreDyslexie);
                    $requete->bindParam(':ScoreDysortho', $this->ScoreDysortho);

                    //execute
                    $requete->execute();

                    if($requete->fetch() == null){ //si trouve rien comme test avec ces parma

                        //si bien enfant, rajoute
                        $query = "INSERT INTO test (IdProf, IdEleve, ScoreTDA, ScoreDyslexie, ScoreDysortho) 
                        VALUES (:IdProf, :IdEleve, :ScoreTDA, :ScoreDyslexie, :ScoreDysortho)";

                        //prepare
                        $requete = $this->bdd->prepare($query); 

                        //mets param dans rq
                        $requete->bindParam(':IdProf', $_SESSION['Id']);
                        $requete->bindParam(':IdEleve', $this->IdEleve);
                        $requete->bindParam(':ScoreTDA', $this->ScoreTDA);
                        $requete->bindParam(':ScoreDyslexie', $this->ScoreDyslexie);
                        $requete->bindParam(':ScoreDysortho', $this->ScoreDysortho);

                        if($requete->execute()) { //execute + vérifie si tout se passe bien.
                            return array();
                        }
                        
                        else { //si erreur dans requète²
                            return array('error'=>'erreur sql');
                        }
                    }
                    else {
                        return array('error'=>'test existe deja');
                    }
                    
                }

                else {
                    return array('error'=>'pas acces a cette eleve');
                }
            
        }
        else {
            return array('error'=>'pas connecter');
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

    public function RecupIdTest($IdTest="All") {  //pour rechcerh pour pour Id, tous les test mais uniquement àpd Id pour àpd élève et prof voir autre fonction
        if(isset($_SESSION['Id'])){//vérifie que connécté
            $All=true; //var bool pour avoir uniquement certaines param
            $Admin=true;

            $query="SELECT 
            Test.IdProf, 
            Prof.Nom as NomProf, 
            Prof.Prenom as PrenomProf, 
            Test.IdEleve, 
            Enfant.Nom as NomEnfant, 
            Enfant.Prenom as PrenomEnfant, 
            Enfant.Annee as AnneeEnfant, 
            Test.Date, ScoreTDA, 
            ScoreDyslexie, 
            ScoreDysortho FROM test Test
            LEFT JOIN enseignant Prof ON Prof.Id = Test.IdProf
            LEFT JOIN eleve Enfant ON Enfant.Id = Test.IdEleve
            WHERE 1=1";

            if(!(isset($_SESSION['Admin']) && $_SESSION['Admin']==true)){ // si pas admin
                $query .= " AND Test.IdProf=:IdProf"; //rajoute condition dans requète
                $Admin=false;
            }
            if($IdTest != 'All'){
                $query .= " AND Test.Id=:Id"; //rajoute condition dans requète
                $All=false;
            }

            $query .= " ORDER BY Test.Id DESC";
            //prépar 
            $requete=$this->bdd->prepare($query);

            //mets param par rapport à ce qu'on veut

            if(!$Admin){
                $requete->bindParam(':IdProf', $_SESSION['Id']);
            }
            if(!$All){
                $requete->bindParam('Id', $IdTest);
            }

            //excute
            $requete->execute();

            $retour=array(); //initialise var de retour
            $retour['data']=array();

            while($rep=$requete->fetch()){
                array_push($retour['data'], $rep);
            }
            if(empty($retour['data'])){
                return array('error'=>'test existe pas');
            }
            return $retour;
        }
        else{
            return array('error'=>'pas connecter');
        }
    }

    public function RecupEnfantTest($IdEnfant, $AllProf=false) {  //mest all prof pour rechercher sur tout les prof
        if(isset($_SESSION['Id'])){//vérifie que connécté
            $Enfant = new Enfant($this->bdd, 'osef token deja session'); // crée objet enfant

            $rep = $Enfant->SelectionnerEnfant($IdEnfant); //regarde si accès à cette enfant

            if(!isset($rep['error'])){ //a trouvé l'enfant
                //fait requète va sélectionner tout les test de cette enfant
                $query = "SELECT Test.Id, 
                Prof.Nom as NomProf, 
                Prof.Prenom as PrenomProf, 
                Test.Date, 
                Test.ScoreTDA, 
                Test.ScoreDyslexie, 
                Test.ScoreDysortho 
                FROM test Test
                LEFT JOIN enseignant Prof ON Prof.Id=Test.IdProf
                WHERE IdEleve=:IdEleve"; 

                //reprépare
                $requete=$this->bdd->prepare($query);

                if($AllProf == false){ //si veut que pour lui
                    $query .= " AND IdProf=:IdProf";    //rajoute la condition que c'est que pour lui.

                    //reprépare
                    $requete=$this->bdd->prepare($query);

                    //mets Id du Prof et suppose que recherche pour lui
                    $requete->bindParam(':IdProf', $_SESSION['Id']);
                }
                else{
                    if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){
                        //pas besoin de rajotuer condition
                    }
                    else{
                        return array('error'=>'pas perm');
                    }
                }

                //mets param pour l'enfant
                $requete->bindParam('IdEleve', $IdEnfant);

                //execute
                $requete->execute();

                //mets dans un endroit tout ces test
                $reponse=array();
                $reponse['data']=array();

                while($retour = $requete->fetch()){
                    array_push($reponse['data'], $retour); //mest dans l'array
                }

                if(empty($reponse['data'])){
                    return array('error'=>'aucun test trouve');
                }

                return $reponse;
            }
            else{
                return array('error'=>'pas acces a cette eleve');
            }
        }
        else{
            return array('error'=>'pas connecter');
        }
    }

    public function RecupProfTest($IdProf) {  
        if(isset($_SESSION['Id'])){//vérifie que connécté

            if(!(isset($_SESSION['Admin']) && $_SESSION['Admin']==true) || $IdProf=='None'){ //si pas admin, peut voir que lui sinon regarde moi pour admin voir que les siens
                $IdProf=$_SESSION['Id'];
            }

            $Enfant = new Enfant($this->bdd, 'osef token deja session'); // crée objet enfant

            $rep = $Enfant->SelectionnerEnfant('All'); //prend tous les enfant du prof

            $sortie=array();
            $sortie['data']=array();

            foreach($rep['data'] as $Eleve){
                //fait requète va sélectionner tout les test de cette enfant
                $query = "SELECT Test.Id, 
                Enfant.Nom as NomEnfant, 
                Enfant.Prenom as PrenomEnfant, 
                Enfant.Annee as AnneeEnfant, 
                Test.Date, 
                Test.ScoreTDA, 
                Test.ScoreDyslexie, 
                Test.ScoreDysortho 
                FROM test Test
                LEFT JOIN eleve Enfant ON Enfant.Id=Test.IdEleve
                WHERE Test.IdEleve=:IdEleve AND Test.IdProf=:IdProf"; 

                //reprépare
                $requete=$this->bdd->prepare($query);

                //mets param
                $requete->bindParam(':IdProf', $IdProf);
                $requete->bindParam('IdEleve', $Eleve['Id']);

                //execute
                $requete->execute();

                //mets dans un endroit tout ces test
                
                while($retour = $requete->fetch()){
                    array_push($sortie['data'], $retour); //mest dans l'array
                }
            }

            if(empty($sortie['data'])){
                return array('error'=>'aucun test trouve');
            }

            return $sortie;
        }
        else{
            return array('error'=>'pas connecter');
        }
    }

    public function DeleteId($IdTest){ //mets all pour supprimer tout celui du prof
        if(isset($_SESSION['Id'])){
            $rep=$this->RecupIdTest($IdTest); //rgarder si le teste exsite
            if(!isset($rep['error'])){
                $query="DELETE FROM test WHERE Id=:Id";//requette suppresion

                $requete=$this->bdd->prepare($query); //la prépare

                $requete->bindParam(':Id', $IdTest);
                
                $requete->execute(); // execute la requète
                return array(); // renvoie que bien passé
            }
            else{
                return $rep;
            }
        }
        else{
            return array('error'=>'pas connecter');
        }
    }

    public function DeleteIdProf($IdProf){
        if(isset($_SESSION['Id'])){
            if($IdProf != $_SESSION['Id'] && !(isset($_SESSION['Admin']) && $_SESSION['Admin']==true)){
                $IdProf=$_SESSION['Id'];
            }
            else{
                $IdProf=$IdProf; //càd que veut bien faire pour cellui là donc ne le modifie pas
            }

            $query="DELETE FROM test WHERE IdProf=:IdProf";//requette suppresion

            $requete=$this->bdd->prepare($query); //la prépare

            $requete->bindParam(':IdProf', $IdProf);
                
            $requete->execute(); // execute la requète
            return array(); // renvoie que bien passé
        }
        else{
            return array('error'=>'pas connecter');
        }
    }
    
    public function DeleteIdEleve($IdEleve){
        if(isset($_SESSION['Id'])){
            if(isset($_SESSION['Admin']) && $_SESSION['Admin'] == true){
                $enfant = new Enfant($this->bdd,'token osef'); //vérifie si la personne a bien accès a l'enfant

                $rep=$enfant->SelectionnerEnfant($IdEleve); //va rechercher élève

                if(!isset($rep['error'])){ //si pas d'erreur donc t

                    $query="DELETE FROM test WHERE IdEleve=:IdEleve";//requette suppresion

                    $requete=$this->bdd->prepare($query); //la prépare

                    $requete->bindParam(':IdEleve', $IdEleve);
                        
                    $requete->execute(); // execute la requète
                    return array(); // renvoie que bien passé
                }
                else{
                    return array('error'=>'pas acces a cette enfant');
                }
            }
            else{
                return array('error'=>'pas perm');
            }
            
        }
        else{
            return array('error'=>'pas connecter');
        }
    }

    public function Recherche($Recherche){
        if(isset($_SESSION['Id'])){
            $enfant = new Enfant($this->bdd, 'osef');
            $prof = new Enseignant($this->bdd, 'osef'); //appel d'avant pour faire recherche

            $RepEnfant = $enfant->Recherche($Recherche); //fait recherche d'avant
            $RepProf = $prof->Rechercher($Recherche);

            //initalile var de srotie
            $resultat = array();
            $resultat['data']=array();
            
            //pour les enfant
            if(!isset($RepEnfant['error']) && !empty($RepEnfant['data'])){ //si pas d'erreur sur enfant au cas pas accès ou je sais quoi
                $resultat['data']['enfant']=array();
                foreach($RepEnfant['data'] as $elem){
                    if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){
                        $rep=$this->RecupEnfantTest($elem['Id'], true); //recheche si admin pour avoir tous les enfant même ce qu'il n'ont pas
                    }
                    else{
                        $rep=$this->RecupEnfantTest($elem['Id']); //recheche pour prof pour avoir que leur élève
                    }
                    if(!isset($rep['error'])){
                        $elem['test']=$rep['data'];
                        array_push($resultat['data']['enfant'], $elem); //mets dans la liste
                    }
                }
            }

            //pour les prof
            if(!isset($RepProf['error']) &&  !empty($RepProf['data'])){ //si pas d'erreur sur enfant au cas pas accès ou je sais quoi
                $resultat['data']['prof']=array();
                foreach($RepProf['data'] as $elem){
                    //var_dump($elem);
                    $rep=$this->RecupProfTest($elem['Id']); //recheche s'il y a des test pour cette enfant dans la limite du prof ou admin
                    if(!isset($rep['error'])){
                        $elem['test']=$rep['data'];
                        array_push($resultat['data']['prof'], $elem); //mets dans la liste
                    }
                }
            }
            return $resultat;
        }
        else{
            return array('error'=>'pas connecter');
        }
    }
}



?>