<?php

require_once 'Auth.php'; //pour vérifier que connecté
class Contact {

    public $Id;
    public $Nom;
    public $Prenom;
    public $Email;
    public $Telelphone;
    public $Desciption;
    public $Specialite;
    private $bdd;


    //Requête création groupe

    public function __construct($db, $Token) {
        $this->bdd = $db;

        $auth = New Auth($db); //créer objet auth
        $reponse = $auth->VerifConnection($Token); //verifie si connecté
        if(!isset($reponse['error'])){ //remets en variable session pour leur requète qui plante
            $_SESSION['Id']=$reponse['Id'];
            $_SESSION['Admin']=$reponse['Admin'];
        }
    }

    public function Create(){
        if(isset($_SESSION['Id'])){
            if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){
                //verifier si existe pas déjà
                $querry="SELECT Id FROM contact WHERE Nom=:Nom AND Prenom=:Prenom";

                //crée requète
                $requete=$this->bdd->prepare($querry);

                //mets param
                $requete->bindParam(':Nom', $this->Nom);
                $requete->bindParam(':Prenom', $this->Prenom);

                //execute
                $requete->execute();

                $rep=$requete->fetch();

                if(!$rep){ //verifie si réponse vide ou pas pour savoir si existe ou pas
                    //si ici, alors existe pas donc l'ajoute

                    //crée requète
                    $querry="INSERT INTO contact (Nom, Prenom, Email, Telephone, Description,  Specialite) VALUES (:Nom, :Prenom, :Email, :Telelphone, :Description, :Specialite)";

                    //fait la requète
                    $requete=$this->bdd->prepare($querry);

                    //mest param
                    $requete->bindParam(':Nom', $this->Nom);
                    $requete->bindParam(':Prenom', $this->Prenom);
                    $requete->bindParam(':Email', $this->Email);
                    $requete->bindParam(':Telelphone', $this->Telelphone);
                    $requete->bindParam(':Description', $this->Description);
                    $requete->bindParam(':Specialite', $this->Specialite);

                    if($requete->execute()){
                       return array(); 
                    }
                    else{
                        return array('error'=>'erreur requete');
                    }
                }
                else{
                    return array('error'=>'contact existe deja');
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

    public function Read($Id="all"){
        if($Id == "all"){ //pour tous
            $querry="SELECT Id, Nom, Prenom, Email, Telephone, Description, Specialite FROM contact"; //fait requète
            //crrée requète
            $requete=$this->bdd->prepare($querry);

            //execute
            $requete->execute();

            //prépare sorite
            $retour=array();
            $retour['data']=array();
            
            while($rep=$requete->fetch()){ //pour chaque élem que l'on trouve
                array_push($retour['data'], $rep); //rajoute dans la var de sorite
            }
            
            return $retour;
        }
        else{ //pour une personne
            $querry="SELECT Nom, Prenom, Email, Telephone, Description, Specialite FROM contact WHERE Id=:Id"; //fait requète
            //crrée requète
            $requete=$this->bdd->prepare($querry);

            //mets parma
            $requete->bindParam(':Id', $Id);

            //execute
            $requete->execute();

            $rep=$requete->fetch();

            $retour=array();
            $retour['data']=$rep;
            
            return $retour;
        }
    }

    public function Research($rech){ //pour rechercher du plus ou moins
        //crée requète
        $querry="SELECT Id, Nom, Prenom, Email, Telephone, Description, Specialite FROM contact WHERE Nom LIKE :rq OR Prenom LIKE :rq OR Specialite LIKE :rq";

        //prépare
        $requete=$this->bdd->prepare($querry);

        $rech = '%'.$rech.'%';//rajoute les % pour recherche dans le mots

        //mets parma
        $requete->bindParam(':rq', $rech);

        $requete->execute();

        //prépare sorite
        $retour=array();
        $retour['data']=array();

        while($rep=$requete->fetch()){ //pour chaque élem que l'on trouve
            array_push($retour['data'], $rep); //rajoute dans la var de sorite
        }

        return $retour;
    }

    public function Update($Id){
        if(isset($_SESSION['Id'])){ //vérifie que connecter
            if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){//verifie que a perm
                //verifie que existe bien
                $querry="SELECT Nom, Prenom, Email, Telephone, Description, Specialite FROM contact WHERE Id=:Id";

                //crée requète
                $requete=$this->bdd->prepare($querry);

                //mets param
                $requete->bindParam(':Id', $Id);

                //execute
                $requete->execute();

                $rep=$requete->fetch();

                if($rep){ //verifie si réponse vide ou pas pour savoir si existe ou pas
                    //si ici c'est que existe donc peut l'update  

                    //crée requète
                    $querry="UPDATE contact SET 
                    Nom=:Nom, 
                    Prenom=:Prenom,
                    Email=:Email,
                    Telephone=:Telelphone,
                    Description=:Description,
                    Specialite=:Specialite WHERE Id=:Id";

                    //fait la requète
                    $requete=$this->bdd->prepare($querry);

                    //mest param si modifie ou pas
                    $requete->bindParam(':Id', $Id);
                    if(!empty($this->Nom)){
                        $requete->bindParam(':Nom', $this->Nom);
                    }
                    else{
                        $requete->bindParam(':Nom', $rep['Nom']);
                    }

                    if(!empty($this->Prenom)){
                        $requete->bindParam(':Prenom', $this->Prenom);
                    }
                    else{
                        $requete->bindParam(':Prenom', $rep['Prenom']);
                    }

                    if(!empty($this->Email)){
                        $requete->bindParam(':Email', $this->Email);
                    }
                    else{
                        $requete->bindParam(':Email', $rep['Email']);
                    }

                    if(!empty($this->Telelphone)){
                        $requete->bindParam(':Telelphone', $this->Telelphone);
                    }
                    else{
                        $requete->bindParam(':Telelphone', $rep['Telelphone']);
                    }
                    
                    if(!empty($this->Description)){
                        $requete->bindParam(':Description', $this->Description);
                    }
                    else{
                        $requete->bindParam(':Description', $rep['Description']);
                    }
                    
                    if(!empty($this->Specialite)){
                        $requete->bindParam(':Specialite', $this->Specialite);
                    }
                    else{
                        $requete->bindParam(':Specialite', $rep['Specialite']);
                    }
                    

                    if($requete->execute()){
                        
                       return array(); 
                    }
                    else{
                        
                        return array('error'=>'erreur requete');
                    }
                }
                else{
                    return array('error'=>'contact existe pas');
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

    public function Delete($Id){
        if(isset($_SESSION['Id'])){ //vérifie que connecter
            if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){//verifie que a perm
                //verifie que existe bien
                $querry="SELECT Id FROM contact WHERE Id=:Id";

                //crée requète
                $requete=$this->bdd->prepare($querry);

                //mets param
                $requete->bindParam(':Id', $Id);

                //execute
                $requete->execute();

                $rep=$requete->fetch();

                if($rep){ //verifie si réponse vide ou pas pour savoir si existe ou pas
                    //si ici c'est que existe donc peut l'update  

                    //crée requète
                    $querry="DELETE FROM contact WHERE Id=:Id";

                    //fait la requète
                    $requete=$this->bdd->prepare($querry);

                    //mest param si modifie ou pas
                    $requete->bindParam(':Id', $Id);

                    if($requete->execute()){
                        
                       return array(); 
                    }
                    else{
                        
                        return array('error'=>'erreur requete');
                    }
                }
                else{
                    return array('error'=>'contact existe pas');
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

    
}

?>