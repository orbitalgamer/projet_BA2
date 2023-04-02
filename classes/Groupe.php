<?php

class Groupe {

    /*
    A FINIR ATTRIBUTION PROF pour une classe spécifique
    */

    public $Idclasse;
    public $Nom;
    private $bdd;
    private $NomTable="classe";

    //Requête création groupe

    public function __construct($db) {
        $this->bdd = $db;
    }

    public function newGroupe() {
        if(isset($_SESSION['Id'])){
            if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){
                //verifie si exsite pas déjà
                $query ="SELECT Id FROM ".$this->NomTable." WHERE Nom=:Nom";
                //preparer
                $requete = $this->bdd->prepare($query);
                $this->Nom=strtolower(htmlspecialchars(strip_tags($this->Nom)));
                //link param
                $requete->bindParam(':Nom', $this->Nom);    
                
                $requete->execute();

                $rep=$requete->fetch();

                if($rep == null){
                    //Crea requête
                    $query = "INSERT INTO classe (Nom) VALUES(:Nom)";
                    
                    //Prepare
                    $requete = $this->bdd->prepare($query);

                    //link param
                    $requete->bindParam(':Nom', $this->Nom);
                    //var_dump($requete);
                    
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
                    return array('error'=>'group existe deja');
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

    public function modifGroupe($Id) {
        //$Id pour stocker Id qu'on utilise

        //comparé à d'autre pas besoin de repdrendre info comme juste un param donc si pas modifier, pas modification de la classe
        if(isset($_SESSION['Id'])){
            if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){
                //verifier que classe existe
                $query = "SELECT Nom FROM classe WHERE Id = :Id";

                //Prepare
                $requete = $this->bdd->prepare($query);

                //link param
                $requete->bindParam(':Id', $Id);

                $requete->execute();

                if($requete->fetch()){
                    //Crea requête
                    $query = "UPDATE classe SET Nom=:Nom WHERE Id = :Id";

                    //Prepare
                    $requete = $this->bdd->prepare($query);
                    $this->Nom=htmlspecialchars(strip_tags($this->Nom));

                    //link param
                    $requete->bindParam(':Nom', $this->Nom);
                    $requete->bindParam(':Id', $Id);


                    if($requete->execute()) {

                        return array();
                    }
                    
                    else {
                        return array('error'=>'param invalide');
                    }
                }
                else{
                    return array('error'=>'classe existe pas');
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


    //fonciton pour sélectionner une classe particulier
    public function SelectRow($IdProf, $IdClasse, $Eleve){
        
        //requète pour nom de la classe
        $querry="SELECT Nom FROM classe WHERE Id=:Id";

        //prepare
        $requete=$this->bdd->prepare($querry);

        //mets param
        $requete->bindParam(':Id', $IdClasse);

        //excute
        $requete->execute();

        //récupère nom
        $retour=$requete->fetch();

        if($IdProf != 'None'){
            //requète pour trouver les prof dans cette classe
            $querry = "SELECT Prof.Nom, Prof.Prenom, Prof.Email 
            FROM classenseignant Lien
            LEFT JOIN enseignant Prof 
            ON Prof.Id = Lien.IdProf
            WHERE Lien.IdClasse=:Id ";

            //preaprer
            $requete=$this->bdd->prepare($querry);

            //si veut que pour 1 prof particulier
            if($IdProf != 'All'){
                $querry .= " AND Prof.Id=:IdProf"; //rajoute condiiton pour prof
                $requete=$this->bdd->prepare($querry); //repréprarer
                $requete->bindParam(':IdProf',$IdProf);
            }
            //si passe pas dedans prend tous les prof

            $requete->bindParam(':Id', $IdClasse);

            //var_dump($requete);
            $requete->execute();

            $retour['Enseignant']=array(); //stock tout les enseignant

            while($rep=$requete->fetch()){ // push différent prof dedans.
                array_push($retour['Enseignant'], $rep);
            }
        }

        if($Eleve){ //si veut les élève de dans
            $querry = "SELECT Nom, Prenom, Annee FROM eleve WHERE IdClasse=:IdClasse"; //sélectrionner pour l'Id voulu
            
            //prépare
            $requete=$this->bdd->prepare($querry);

            $requete->bindParam(':IdClasse', $IdClasse);

            $requete->execute();
            $retour['Enfant']=array();

            while($rep=$requete->fetch()){ // push différent prof dedans.
                array_push($retour['Enfant'], $rep);
            }
        }
        return $retour;
    }

    public function Selectionner($IdProf='None', $IdClasse='All', $Eleve=false){
        /*
        différent param :
            $IdProf='None' càd que veut pas de prof
            $IdProf=nombre veut que pour ce prof là
            $IdProf='All' veut tout les prof

            $IdClasse='All' pour prendre toutes les calsse
            $IdClasse=nomre veut que pour cette classe la

            $Eleve=true si veut les élève dedans

        */

        //check si conencter
        if(isset($_SESSION['Id'])){
            if($IdProf == 'None'){ //regarde si veut pas de prof
                if(!(isset($_SESSION['Admin']) && $_SESSION['Admin']==true)){ //si pas admin, peut que regarder class qu'il a lui même
                    $IdProf=$_SESSION['Id']; //renvoie que ces informations car si pas admin peut pas accèder aux autres
                }
                //sinon admin peut tout voir
            }
            else if($IdProf == 'All'){
                if(!(isset($_SESSION['Admin']) && $_SESSION['Admin']==true)){ //si pas admin et que veut tous, envoie pas perm
                    return array('error'=>'pas perm');
                }
            }
            else{
                if($_SESSION['Id'] != $IdProf && !(isset($_SESSION['Admin']) && $_SESSION['Admin']==true)){ //si cherche pour Id différent de lui, alors doit être admin
                    return array('error'=>'pas perm');
                }
            }

            if($IdClasse != 'All'){  //si veut que une classe
                $Row= $this->SelectRow($IdProf, $IdClasse, $Eleve); //fait requète pour cette calsse
                if($Row){
                    $retour=array();
                    $retour['data']=$Row;
                    return $retour;
                }
                else{
                    return array('error'=>'pas acces classe');
                }

            }
            else if($IdClasse == 'All' && $IdProf != 'All' && $IdProf !='None'){ //requète pour rechercher pour 1 prof
                //fait requète pour trouver nom et id classe àpd de l'id du prof

                $querry = "SELECT Classe.Nom, Classe.Id 
                            FROM classenseignant Lien 
                            LEFT JOIN classe Classe 
                            ON Classe.Id=Lien.IdClasse  
                            WHERE IdProf=:IdProf"; 

                //preparer
                $requete=$this->bdd->prepare($querry);

                //mettre param
                $requete->bindParam(':IdProf', $IdProf);
                

                //excute
                $requete->execute();

                //créer array pour le retour
                $retour=array();
                $retour['data']=array();
                
                while($rep=$requete->fetch()){
                    $Row = $this->SelectRow('None',$rep['Id'],$Eleve); // force type prof à none car sert à rien de récuperer comme connait déjà l'Id du pro 
                    if(isset($Row['Enfant'])){ //si veut enfant
                        $rep['Enfant']=$Row['Enfant'];
                    }

                    array_push($retour['data'], $rep); //rajoute cette classe à la suite
                }
                return $retour;

            }
            else if($IdClasse == 'All'){ //faire pour toutes les profs

                //cherche tout les calsse avec leur Id
                $querry = "SELECT Id, Nom FROM classe";
                
                //prepare
                $requete=$this->bdd->prepare($querry);

                //execute
                $requete->execute();

                //déclare var de retour
                $retour=array();
                $retour['data']=array();
                
                while($rep=$requete->fetch()){
                    $Row = $this->SelectRow($IdProf,$rep['Id'],$Eleve);
                    //var_dump($Row);
                    if(isset($Row['Enseignant'])){
                        $rep['Enseignant']=$Row['Enseignant'];
                    }
                    if(isset($Row['Enfant'])){
                        $rep['Enfant']=$Row['Enfant'];
                    }
                    array_push($retour['data'], $rep);
                }
                return $retour;
            }
            else{
                return array('error'=>'param invalide');
            }
        }
        else{
            return array('error'=>'pas connecter');
        }
    }

    //supprimer complètement classe
    public function DeleteClasse($IdClasse){

        if(isset($_SESSION['Id'])){
            if(isset($_SESSION['Admin']) && $_SESSION['Admin'] == true){
                //verrifier si calsse existe.
                $Classe=$this->SelectRow('None', $IdClasse, false); 
                if(isset($Classe)){
                    //requète pour supprimer la classe et tout ce liens
                    $querry="DELETE Classe, Lien FROM classe Classe 
                    INNER JOIN classenseignant Lien 
                    ON Lien.IdClasse=Classe.Id
                    WHERE Classe.Id=:Id";

                    //prepare
                    $requete=$this->bdd->prepare($querry);

                    //mets param
                    $requete->bindParam(':Id', $IdClasse);

                    //execute la requète
                    $requete->execute();

                    //va retier l'IdClasse chez élève
                    $querry="UPDATE eleve SET IdClasse = NULL WHERE IdClasse=:Id";

                    //prepare
                    $requete=$this->bdd->prepare($querry);

                    //mets param
                    $requete->bindParam(':Id', $IdClasse);

                    //execute la requète
                    $requete->execute();
                }
                else{
                    return array('error'=>'classe existe pas');
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

    //désalouer classe
    public function Desalouer($IdProf=-42,$IdClasse=-42){
        if(isset($_SESSION['Id'])){
            if(isset($_SESSION['Admin']) && $_SESSION['Admin'] == true){
                //pour supprimer à partir d'un prof
                if($IdProf != -42 && $IdClasse==-42){ //pour supprimer tout de ce prof
                    $querry="DELETE FROM classenseignant WHERE IdProf=:IdProf";

                    //prepare
                    $requete=$this->bdd->prepare($querry);

                    //mets param
                    $requete->bindParam(':IdProf', $IdProf);

                    //execute la requète
                    $requete->execute();
                }
                else if($IdClasse != -42 && $IdProf==-42){ //pour supprimer tout ce cette classe
                    $querry="DELETE FROM classenseignant WHERE IdClasse=:IdProf";

                    //prepare
                    $requete=$this->bdd->prepare($querry);

                    //mets param
                    $requete->bindParam(':IdProf', $IdClasse);

                    //execute la requète
                    $requete->execute();
                }
                else if($IdClasse != -42 && $IdProf !=-42){ //pour supprimer accès d'un prof a une classe
                    $querry="DELETE FROM classenseignant WHERE IdClasse=:IdClasse AND IdProf=:IdProf";

                    //prepare
                    $requete=$this->bdd->prepare($querry);

                    //mets param
                    $requete->bindParam(':IdProf', $IdProf);
                    $requete->bindParam(':IdClasse', $IdClasse);

                    //execute la requète
                    $requete->execute();
                }
                else{
                    return array('error'=>'param invalide');    
                }
                return array();
            }
            else{
                return array('error'=>'pas perm');
            }
        }
        else{
            return array('error'=>'pas connecter');
        }
    }
    public function Allouer($IdProf, $IdClasse){


        if(isset($_SESSION['Id'])){
            if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){
                //verifier que prof déjà pas cette classe
                $querry ="SELECT Id FROM classenseignant WHERE IdProf=:IdProf AND IdClasse=:IdClasse";
                
                //créer requète
                $requete=$this->bdd->prepare($querry);

                //mettre param
                $requete->bindParam(':IdProf', $IdProf);
                $requete->bindParam(':IdClasse', $IdClasse);

                //excute
                $requete->execute();

                //regarder les données
                $rep=$requete->fetch();
                

                if($rep == null){ //si existe rien
                   
                    //vérifier si classe existe
                    $querry ="SELECT Nom FROM classe WHERE Id=:Id";

                    //créer requète
                    $requete=$this->bdd->prepare($querry);

                    //mettre param
                    $requete->bindParam(':Id', $IdClasse);

                    //excute
                    $requete->execute();

                    //regarder les données
                    $rep=$requete->fetch();

                    if($rep != null){
                        //requète
                        $querry ="INSERT INTO classenseignant (IdProf, IdClasse) VALUES (:IdProf, :IdClasse)";
                        //créer requète
                        $requete=$this->bdd->prepare($querry);

                        //mettre param
                        $requete->bindParam(':IdProf', $IdProf);
                        $requete->bindParam(':IdClasse', $IdClasse);
                        
                        //excute
                        $requete->execute();
                    }
                    else{
                        return array('error'=>'classe existe pas');
                    }
                    
                }
                else{
                    return array('error'=>'prof deja acces a la classe');
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
