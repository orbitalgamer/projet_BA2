<?php

require_once 'Auth.php'; //pour vérifier que connecté
class Enseignant{
    public $Id;
    public $Nom;
    public $Prenom;
    public $Email;
    public $Mdp;
    public $Admin;
    public $Identifiant;

    private $NomTable ="enseignant";
    private $Bdd;


    //cosntrctuteur pour définir objet Bdd pour objet PDO
    public function __construct($db, $Token){
        $this->Bdd=$db;

        $auth = New Auth($db); //créer objet auth
        $reponse = $auth->VerifConnection($Token); //verifie si connecté
        if(!isset($reponse['error'])){ //remets en variable session pour leur requète qui plante
            $_SESSION['Id']=$reponse['Id'];
            $_SESSION['Admin']=$reponse['Admin'];
        }
    }

    public function Creation(){
        if(isset($_SESSION['Id'])){
            if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){ //verif si admin
                //commence à verifier si existe déjà pas ce prof
                $querry = "SELECT Id, Email, Mdp, Admin FROM ".$this->NomTable." WHERE Nom= :Nom && Prenom= :Prenom";
                
                //prend nom et prneom
                $this->Nom = strtolower(htmlspecialchars(strip_tags($this->Nom))); 
                $this->Prenom = strtolower(htmlspecialchars(strip_tags($this->Prenom)));

                //prepare
                $rq = $this->Bdd->prepare($querry);
                //binde param
                $rq->bindParam(':Nom',$this->Nom);
                $rq->bindParam(':Prenom',$this->Prenom);
                //execute
                $rq->execute();

                if($rep=$rq->fetch() == null){ // si existe pas
                    //écriture requète
                    $querry ="INSERT INTO ". $this->NomTable." (Nom, Prenom, Email, Mdp) VALUES (:Nom, :Prenom, :Email, :Mdp)";

                    $rq = $this->Bdd->prepare($querry);
                    //supprimer les chose pas voule comme des balises html
                    $this->Email = strtolower(htmlspecialchars(strip_tags($this->Email)));
                    $this->Mdp =  password_hash($this->Mdp, PASSWORD_DEFAULT);        
                    
                    //mettre param dans requète
                    $rq->bindParam(':Nom', $this->Nom);
                    $rq->bindParam(':Prenom', $this->Prenom);
                    $rq->bindParam(':Email', $this->Email);
                    $rq->bindParam(':Mdp', $this->Mdp);

                    //executer
                    if($rq->execute()){
                        return array();
                    };
                }
                else{
                    return array('error'=>'prof existe deja');
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

    public function Selectionner($IdProf=-42){
        if(isset($_SESSION['Id'])){ //vérifie que connecter
            
            //slection ces info
            if($IdProf == -42){

                $querry = "SELECT Nom, Prenom, Email, Admin FROM ".$this->NomTable." WHERE Id= :Id"; //rquète
                
                //recupète son propre Id
                $this->Id=$_SESSION['Id']; //sinon ne peut que rercher pour lui

                $rq = $this->Bdd->prepare($querry); //preparer requète
                
                $rq->bindParam(':Id',$this->Id); //mettre les param
                
                //faire requète
                $rq->execute();
                $rep=$rq->fetch();
                $reponse = array(); // créer array principale pour dire si trouvé ou pas
                $reponse['data'] =array(); // créer array secondaire pour toutes les data
                if($rep == null){ //si rien de trouvé
                    $reponse['error']="id introuvable";
                }
                else{ //si trouve queluqe chose
                    if($rep['Email'] != "DELETED"){
                        array_push($reponse['data'], $rep); //ainsi rajoute dans data
                    }
                }
                return $reponse; //renvoie réponse
            
            }
            //pour sélectrionner tous les prof
            else if($IdProf=="All"){
                if((isset($_SESSION['Admin']) && $_SESSION['Admin']==true)){

                    //selection tout les prof
                    $querry = "SELECT Id, Nom, Prenom, Email, Admin FROM ".$this->NomTable;

                    //preparer
                    $rq = $this->Bdd->prepare($querry);
                    //executé

                    $rq->execute();

                    //stock réponse
                    $reponse = array(); //sert normalmenet pou erreur plus erreur possible mais pour garder même structure
                    $reponse['data']=array(); //pour stocké réellement donné
                    
                    //créer compteur pour donné ordre des prof
                    $compteur=0;
                    
                    while($rep=$rq->fetch()){
                        if($rep['Email'] != "DELETED"){ //sert pour verifier si on l'a pas supprimer
                            $reponse['data'][$compteur]=$rep; //rajoute prof
                            $compteur++;
                        }
                    }
                    return $reponse;
                }
                else{
                    return array('error'=>'pas perm');
                }
            }
            else{
                if(isset($_SESSION['Admin']) && $_SESSION['Admin'] == true){ //si admin, droit de chercher pour tous les prof
                    
                    //recherche sur l'id voulu
                    $this->Id=$IdProf;

                    //querry
                    $querry = "SELECT Nom, Prenom, Email, Admin FROM ".$this->NomTable." WHERE Id= :Id"; //rquète
                
    
                    $rq = $this->Bdd->prepare($querry); //preparer requète
                    
                    $rq->bindParam(':Id',$this->Id); //mettre les param
                    
                    //faire requète
                    $rq->execute();
                    $rep=$rq->fetch();
                    $reponse = array(); // créer array principale pour dire si trouvé ou pas
                    $reponse['data'] =array(); // créer array secondaire pour toutes les data

                    if($rep != null){
                        array_push($reponse['data'], $rep); //rajouter les data même si compte supprimer car admin
                    }
                    else{
                        $reponse['error']="id introuvable";
                    }
                    return $reponse;
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

    public function Modifier($Id = -42){
        if(isset($_SESSION['Id'])){
            if($Id != -42){
                if(isset($_SESSION['Admin']) && $_SESSION['Admin']==1){
                    $this->Id=$Id; //si admin, prend cette id pour modifier
                }
                else{
                    return array('error'=>'pas perm');
                }
            }
            else{
                $this->Id=$_SESSION['Id']; //peut modifier que son propre Id
            }
            // va reprendre info pour pas écraser ce qu'on connait déjà
             //cheche tout info sur cette Id
            $querry ="SELECT Nom, Prenom, Email, Mdp, Admin FROM ".$this->NomTable." WHERE Id= :id";

            $rq=$this->Bdd->prepare($querry);

            $rq->bindParam(':id',$this->Id);

            $rq->execute();

            $rep=$rq->fetch();

            if($rep != null){

                //requète
                $querry ="UPDATE ".$this->NomTable." SET Nom=:nom, Prenom=:prenom, Email=:email, Mdp=:mdp, Admin=:admin WHERE Id=:id";

                $rq=$this->Bdd->prepare($querry);

                //si pas redefini, reprend ancienne valeur
                if(!isset($this->Nom)){
                    $this->Nom=$rep['Nom'];
                }

                if(!isset($this->Prenom)){
                    $this->Prenom=$rep['Prenom'];
                }

                if(!isset($this->Email)){
                    $this->Email=$rep['Email'];
                }

                if(!isset($this->Admin)){
                    $this->Admin=$rep['Admin'];
                }


                if(isset($this->Mdp)){
                    $this->Mdp=password_hash($this->Mdp, PASSWORD_DEFAULT);
                }
                else{
                    $this->Mdp=$rep['Mdp'];
                }

                //link les param
                $rq->bindParam(':nom',$this->Nom);
                $rq->bindParam(':prenom',$this->Prenom);
                $rq->bindParam(':email',$this->Email);
                $rq->bindParam(':mdp',$this->Mdp);
                $rq->bindParam(':admin',$this->Admin);
                $rq->bindParam(':id',$this->Id);

                if($rq->execute()){
                    return array();
                }

                //gestion erreur
                else{
                    return array('error'=>'param invalide');
                }
            }
            else{
                return array('error'=>'prof introuvable');
            }
        }
        else{
            return array('error'=>'pas connecter');
        }

    }

    public function Supprimer(){
        if(isset($_SESSION['Id'])){ //verifie si connecter
            if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){ //verifie si admin
                //va update et mettre que Email=DELETED pour savoir que compte supprimer mais quand même garder nom pour savoir qui a fait quoi pour suivi
                $querry = "UPDATE ".$this->NomTable." SET Email='DELETED', MDP='DELETED', Admin=0 WHERE Id= :id";

                //prepare
                $rq=$this->Bdd->prepare($querry);

                //mets param
                $rq->bindParam(':id', $this->Id);

                //execute
                if(!$rq->execute()){
                    return array('error'=>'param invalide');
                }
                //gestion erreur après
            }
            else{
                return array('error'=>'pas perm');
            }
        }
       
    }
    public function Rechercher($recherche){
        if(isset($_SESSION['Id'])){
            if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){
                //création requète mets pas encore le like
                $querry="SELECT Id, Nom, Prenom, Email, Admin FROM enseignant WHERE Nom LIKE :rq OR Prenom LIKE :rq OR Email LIKE :rq"; 
                
                //mets les % pour fair requète like
                $recherche= '%'.$recherche.'%';

                //prépare
                $requete=$this->Bdd->prepare($querry);

                //mets param :
                $requete->bindParam(':rq', $recherche);

                //execute
                $requete->execute();

                //créé stockage de donnée
                 $reponse = array(); 
                 $reponse['data']=array();
                 
                 //créer compteur pour donné ordre des prof pour avoir ordre continue et plus simple pour lire après
                 $compteur=0;
                 
                 while($rep=$requete->fetch()){
                         $reponse['data'][$compteur]=$rep; //rajoute prof
                         $compteur++;
                 }
                 return $reponse;
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