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

        $auth = New Auth($db); //créer objet auth
        $reponse = $auth->VerifConnection($Token); //verifie si connecté
        if(!isset($reponse['error'])){ //remets en variable session pour leur requète qui plante
            $_SESSION['Id']=$reponse['Id'];
            $_SESSION['Admin']=$reponse['Admin'];
        }
    }

    public function newEnfant() {
        
        if(isset($_SESSION['Id'])){
            if(isset($_SESSION['Admin']) && $_SESSION['Admin'] == true){
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
                if($search == null) {
                    //verifier que classe existe
                    $query = "SELECT Nom FROM classe WHERE Id=:Id";

                    //prépare
                    $requete=$this->bdd->prepare($query);

                    $requete->bindParam(':Id', $this->IdClasse);

                    $requete->execute();

                    $rep=$requete->fetch();

                    if($rep != null){
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
                            return array();
                        }       
                        else {
                            return array('error'=>'param invalide');
                        }

                    }
                    else {
                        return array('error'=>'classe existe pas');
                    }
                    
                }
                else{
                    return array('error'=>'enfant existe deja');
                }
            }
            else {
                return array('error'=>'pas perm');
            }
        }
        else {
            return array('error'=>'pas connecter');
        }
    }

    //seleciton 1 enfant
    public function SelectionnerEnfant($IdEnfant){
        /*
        pour sélectionner enfant, prof doit avoir accès à la classe
        ou sinon doit être admin.
        */

        //va définir Id du prof si recherche pour quelqu'un d'autre que lui
        if(isset($_SESSION['Id'])){
            if($IdEnfant != 'All'){ //si veut 1 enfant en particulier
                if(isset($_SESSION['Admin']) && $_SESSION['Admin'] == true){

                    //si admin peut voir tous les enfant sans problème
                    $query="SELECT Enfant.Id, Enfant.Nom, Enfant.Prenom, Enfant.Annee, Classe.Id as IdClasse, Classe.Nom as NomClasse 
                    FROM eleve Enfant
                    LEFT JOIN classe Classe
                    ON Classe.Id=Enfant.IdClasse
                    WHERE Enfant.Id=:IdEnfant";

                    $rq=$this->bdd->prepare($query);

                    $rq->bindParam(':IdEnfant',$IdEnfant);

                    $rq->execute();

                    $retour=array();
                    $retour['data']=array();
                    
                    if($rep=$rq->fetch()){
                        $retour['data']=$rep;
                        return $retour;
                    }
                    else{
                        return array('error'=>'enfant existe pas');
                    }
                }
                else{ //pour quand pas admin
                    //requète pour récupe info enfant + classe pour le prof en question
                    $query="SELECT Enfant.Id, Enfant.Nom, Enfant.Prenom, Enfant.Annee, Enfant.IdClasse, Classe.Nom as NomClasse 
                    FROM eleve Enfant
                    LEFT JOIN classenseignant Lien
                    ON Lien.IdClasse=Enfant.IdClasse
                    LEFT JOIN classe Classe
                    ON Classe.Id=Lien.IdClasse
                    WHERE Enfant.Id=:Id AND Lien.IdProf=:IdProf";

                    //prepare
                    $requete=$this->bdd->prepare($query);

                    //mets les param
                    $requete->bindParam(':Id', $IdEnfant);
                    $requete->bindParam(':IdProf', $_SESSION['Id']);

                    //execute
                    $requete->execute();

                    //reécupère donné
                    $rep=$requete->fetch();

                    $retour=array();
                    $retour['data']=array();

                    if($rep != null){ //si on a des données
                        $retour['data']=$rep;
                        return $retour;
                    }
                    else{
                        return array('error'=>'eleve existe pas');
                    }
                }
            }
            else if($IdEnfant == 'All'){
                if(isset($_SESSION['Admin']) && $_SESSION['Admin'] == true){

                    //si admin peut voir tous les enfant sans problème
                    $query="SELECT Enfant.Id, Enfant.Nom, Enfant.Prenom, Enfant.Annee, Classe.Id as IdClasse, Classe.Nom as NomClasse 
                    FROM eleve Enfant
                    LEFT JOIN classe Classe
                    ON Classe.Id=Enfant.IdClasse ORDER BY Enfant.Id DESC";

                    $rq=$this->bdd->prepare($query);


                    $rq->execute();

                    $retour=array();
                    $retour['data']=array();
                    
                    while($rep=$rq->fetch())
                    {
                        array_push($retour['data'], $rep);
                    }
                    return $retour;
                }
                else{
                    return array('error'=>'pas perm');  
                }
            }
            
        }
        else{
            return array('error'=>'pas connecter');
        }
    }



    public function Selectionner($IdClasse='None', $IdProf=5){
        /*
        réflexion: prof à le droit de voir enfant qu'il a en cours
        admin droit de tous les voir

        doit pouvoir sélection àpd IdClasse si on a besoin donc doit aussi vérifier que prof à bien cette classe sauf si admin

        mais admin doit aussi pouvoir faire autre chose

        doit pouvoir sélectionner 1 enfant en particulier => a faire dans fonction à part


        rester à gerer quand admin et veut voir absolument toutes les classe


        rajouter que si admin, prend pas en compte càd que si veux peut tout voir
        */

        
        if(isset($_SESSION['Id'])){
            //reagder si veut regarder pour Id diférent de lui
            if($IdProf != $_SESSION['Id']){
                if(isset($_SESSION['Admin']) && $_SESSION['Admin'] == true){
                    
                }
                else{
                    return array('error'=>'pas perm');
                }
                //sinon continu
            }

            if($IdClasse=='None'){ //si veut toutes les classe

                //fait requète pour avoir toutes les classe du prof
                $query="SELECT Classe.Id as IdClasse, Classe.Nom as NomClasse FROM 
                classenseignant Lien
                LEFT JOIN
                classe Classe
                ON Classe.Id=Lien.IdClasse
                WHERE Lien.IdProf=:IdProf";

                //preparer
                $requete=$this->bdd->prepare($query);

                //mettre param
                $requete->bindParam(':IdProf',$IdProf);

                //execute la requète
                $requete->execute();

                //crée variable de retour pour pouvoir push dedans après
                $retour=array();
                $retour['data']=array();

                while($rep=$requete->fetch()){
                    $rep['Enfant']=array(); //va permetre pour une classe de mettre tous les enfant de dans
                    //tant que trouve classe
                    //va rechercher tous les enfant de cette classe
                    $query="SELECT Id,Nom, Prenom, Annee FROM eleve WHERE IdClasse=:IdClasse";

                    $rq=$this->bdd->prepare($query);

                    $rq->bindParam(':IdClasse',$rep['IdClasse']);

                    $rq->execute();

                    while($enfant=$rq->fetch()){
                        //tant que trouve enfant, mets dans l'array pour la classe
                        array_push($rep['Enfant'],$enfant);
                    }
                    array_push($retour['data'], $rep);
                }

                //une foi que tout pris renvoie info
                return $retour;
            }
            //param all pour prendre toutes si admin
            else if($IdClasse=='All'){
                if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){
                    //prend toutes les classe
                    $query = "SELECT Id as IdClasse, Nom as NomClasse FROM classe";

                    //prepéare
                    $requete=$this->bdd->prepare($query);

                    //écute et comme par param
                    $requete->execute();

                    //prépare le retour
                    $retour=array();
                    $retour['data']=array();
                    while($rep=$requete->fetch()){
                        $rep['Enfant']=array(); //va permetre pour une classe de mettre tous les enfant de dans
                        //tant que trouve classe
                        //va rechercher tous les enfant de cette classe
                        $query="SELECT Id,Nom, Prenom, Annee FROM eleve WHERE IdClasse=:IdClasse";

                        $rq=$this->bdd->prepare($query);

                        $rq->bindParam(':IdClasse',$rep['IdClasse']);

                        $rq->execute();

                        while($enfant=$rq->fetch()){
                            //tant que trouve enfant, mets dans l'array pour la classe
                            array_push($rep['Enfant'],$enfant);
                        }
                        array_push($retour['data'], $rep);
                    }
                    return $retour;
                }
                else{
                    return array('error'=>'pas perm');
                }

            }
            else{
                
                //fait requète pour avoir toutes les classe du prof
                if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){
                    $query="SELECT Classe.Id as IdClasse, Classe.Nom as NomClasse FROM 
                    classenseignant Lien
                    LEFT JOIN
                    classe Classe
                    ON Classe.Id=Lien.IdClasse
                    WHERE Lien.IdClasse=:IdClasse";
                    //preparer
                $requete=$this->bdd->prepare($query);
                }
                else{
                    $query="SELECT Classe.Id as IdClasse, Classe.Nom as NomClasse FROM 
                    classenseignant Lien
                    LEFT JOIN
                    classe Classe
                    ON Classe.Id=Lien.IdClasse
                    WHERE Lien.IdClasse=:IdClasse AND Lien.IdProf=:IdProf";
                    //preparer
                    $requete=$this->bdd->prepare($query);
                    //metre param
                    $requete->bindParam(':IdProf',$IdProf);
                }   

                //mettre param
                $requete->bindParam(':IdClasse',$IdClasse);

                //execute la requète
                $requete->execute();

                //crée variable de retour pour pouvoir push dedans après
                $retour=array();
                $retour['data']=array();

                if($rep=$requete->fetch()){
                    $rep['Enfant']=array(); //va permetre pour une classe de mettre tous les enfant de dans
                    //tant que trouve classe
                    //va rechercher tous les enfant de cette classe
                    $query="SELECT Id,Nom, Prenom, Annee FROM eleve WHERE IdClasse=:IdClasse";

                    $rq=$this->bdd->prepare($query);

                    $rq->bindParam(':IdClasse',$rep['IdClasse']);

                    $rq->execute();

                    while($enfant=$rq->fetch()){
                        //tant que trouve enfant, mets dans l'array pour la classe
                        array_push($rep['Enfant'],$enfant);
                    }
                    array_push($retour['data'], $rep);
                    //renvoi donné
                    return $retour;
                }
                else{
                    return array('error'=>'prof pas acces a cette classe');
                }  
            }
        }
        else{
            return array('error'=>'pas connecter');
        }

    }

    public function Update($IdEnfant){
        //verifie si connecter
        if(isset($_SESSION['Id'])){
            //verifie si admin
            if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){
                //recupère ancienne ifno
                $query="SELECT Nom,Prenom,Annee,IdClasse FROM eleve WHERE Id=:Id";

                //prépare
                $requete=$this->bdd->prepare($query);

                //mets parma
                $requete->bindParam(':Id',$IdEnfant);

                //execute
                $requete->execute();

                $rep=$requete->fetch();

                if($rep != null){

                    //si param pas définit, alors pas modiei
                    if(!isset($this->Nom)){
                        $this->Nom=$rep['Nom'];
                    }
                    if(!isset($this->Prenom)){
                        $this->Prenom=$rep['Prenom'];
                    }
                    if(!isset($this->Annee)){
                        $this->Annee=$rep['Annee'];
                    }
                    if(!isset($this->IdClasse)){
                        $this->IdClasse=$rep['IdClasse'];
                    }
                    else{
                        //vérifier ce classe existe
                        $query="SELECT Nom FROM classe WHERE Id=:Id";

                        //prépare
                        $requete=$this->bdd->prepare($query);

                        //mets parma
                        $requete->bindParam(':Id',$this->IdClasse);

                        //execute
                        $requete->execute();

                        $rep=$requete->fetch();

                        if($rep == null){
                            return array('error'=>'classe existe pas');
                        }
                        //sinon continue
                    }

                    //maitnenant on a touls param, peut mettre à jour

                    //requète update
                    $query="UPDATE eleve SET Nom=:Nom, Prenom=:Prenom, Annee=:Annee, IdClasse=:IdClasse WHERE Id=:Id";

                    //prépare
                    $requete=$this->bdd->prepare($query);

                    //mets param
                    $requete->bindParam(':Nom', $this->Nom);
                    $requete->bindParam(':Prenom', $this->Prenom);
                    $requete->bindParam(':Annee', $this->Annee);
                    $requete->bindParam(':IdClasse', $this->IdClasse);
                    $requete->bindParam(':Id', $IdEnfant);

                    if($requete->execute()){
                        return array();
                    }
                    else{
                        return array('error'=>'param invalide');
                    }

                }
                else{
                    return array('error'=>'eleve existe pas');
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

    public function Delete($IdEnfant){ //pour supprimer enfant
        if(isset($_SESSION['Id'])){
            if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){
                //créer requète
                $query="DELETE Enfant, Test FROM eleve Enfant
                LEFT JOIN test Test
                ON Test.IdEleve=Enfant.Id
                WHERE Enfant.Id=:Id";

                //prépare
                $requete=$this->bdd->prepare($query);

                //mets param
                $requete->bindParam(':Id',$IdEnfant);

                if($requete->execute()){
                    return array();
                }
                else{
                    return array('error'=>'param invalide');
                }

            }
            else{
                return array('error'=>'pas perm');
            }
        }
        else{
            return array('error'=>'pas connecter');
        }
        //cree requète
    }
}

?>