<?php

class Fiche {

    public $Id;
    public $Nom;
    public $Sujet;
    public $Json;
    private $Bdd;


    //Requête création groupe
    public function __construct($db) {
        $this->Bdd = $db;

        $auth = New Auth($db); //créer objet auth
        $reponse = $auth->VerifConnection($Token); //verifie si connecté
        if(!isset($reponse['error'])){ //remets en variable session pour leur requète qui plante
            $_SESSION['Id']=$reponse['Id'];
            $_SESSION['Admin']=$reponse['Admin'];
        }
    }

    public function Create(){ //création fiche info

        if(isset($_SESSION['Id'])){
            if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){
                //verifier si existe pas déjà
                $query="SELECT Id FROM fiche WHERE Nom=:Nom AND Sujet=:Sujet";

                //pépare requète
                $requete=$this->Bdd->prepare($query);

                //mettre param
                $requete->bindParam(':Nom', $this->Nom);
                $requete->bindParam(':Sujet', strtolower($this->Sujet));

                //execute
                $requete->execute();

                if($requete->fetch() == null){
                    //créer test:
                    $query="INSERT INTO fiche (Nom, Sujet) VALUES (:Nom, :Sujet)";

                    //pépare requète
                    $requete=$this->Bdd->prepare($query);

                    //mettre param
                    $requete->bindParam(':Nom', $this->Nom);
                    $requete->bindParam(':Sujet', $this->Sujet);

                    //execute
                    $requete->execute();

                    //récupérer Id de la nouvelle fiche càd que prend dernière Id 
                    $query="SELECT Id FROM fiche WHERE Nom=:Nom AND Sujet=:Sujet ORDER BY Id DESC LIMIT 1";

                    //pépare requète
                    $requete=$this->Bdd->prepare($query);

                    //mettre param
                    $requete->bindParam(':Nom', $this->Nom);
                    $requete->bindParam(':Sujet', $this->Sujet);

                    //execute
                    $requete->execute();

                    //fetch pour récup info
                    $rep=$requete->fetch();

                    if($rep){
                        $Fichier=fopen("../../Fiches/".$rep['Id'].".json", "w"); //ouvrer et créer fichier pour cette Id
                        if($Fichier){
                            fwrite($Fichier, json_encode($this->Json));
                            fclose($Fichier);
                            return array();
                        }
                        else{
                            return array('error'=>'erreur creation fiche');    
                        }
                    }
                    else{
                        return array('error'=>'erreur interne');
                    }
                }
                else{
                    return array('error'=>'fiche existe deja');
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

    public function Read($Id="All"){ // pour lire une fiche particulier ou All pour toutes
        if($Id!="All"){
            //création requète
            $query="SELECT Nom, Sujet FROM fiche WHERE Id=:Id";

            //preparer
            $requete=$this->Bdd->prepare($query);

            //mettre parm
            $requete->bindParam(':Id', $Id);

            //executé
            $requete->execute();

            //récupe
            $rep=$requete->fetch();

            //si fichier existe
            if($rep){
                $url="../../Fiches/".$Id.".json";
                $Fichier=fopen($url, "r"); // ouvre ficheir
                if($Fichier){
                    $text=fread($Fichier,filesize($url));
                    $retour['data']=json_decode($text);
                    return $retour;
                }
                else{
                    return array('error'=>'fichier introuvable');
                }
            }
            else{
                return array('error'=>'fiche existe pas');
            }
        }
        else{
            //requète
            $query="SELECT Id, Nom, Sujet FROM fiche";

            //crée requète
            $requete=$this->Bdd->prepare($query);            

            //execute
            $requete->execute();

            //prépare la sorite
            $retour=array();
            $retour['data']=array();

            //prend chauqe réponse et mest dans la sortie 
            while($rep=$requete->fetch()){
                array_push($retour['data'], $rep);
            }
            return $retour;
        }
    }

    public function ReadLike($Sujet){ //sélectionnai Sujet approximative genre dys => dysorthographie
        if(strlen($Sujet)>=2){
            //requète pour avoir tous les sujets correspondant
            $query="SELECT Id, Nom, Sujet FROM fiche WHERE Sujet LIKE :Sujet LIMIT 15";

            //crée requète
            $requete=$this->Bdd->prepare($query);

            //mettre param
            $Sujet='%'.strtolower($Sujet).'%'; //doit rajouter patern pour dire que sujet peut être patout dans le nom
            $requete->bindParam(':Sujet',$Sujet);

            //execute
            $requete->execute();

            //prépare la sorite
            $retour=array();
            $retour['data']=array();

            //prend chauqe réponse et mest dans la sortie 
            while($rep=$requete->fetch()){
                array_push($retour['data'], $rep);
            }
            return $retour;
        }
    }

    public function Update($Id){
        if(isset($_SESSION['Id'])){
            if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){
                //commencer par vérifier si Fiche exsite

                $query="SELECT Nom, Sujet FROM fiche WHERE Id=:Id";

                //pépare requète
                $requete=$this->Bdd->prepare($query);

                //mettre param
                $requete->bindParam(':Id', $Id);

                //execute
                $requete->execute();

                //récupère données
                $rep=$requete->fetch();

                if($rep != null){ //si existe
                    if(!isset($this->Nom)){
                        $this->Nom=$rep['Nom'];
                    }
                    if(!isset($this->Sujet)){
                        $this->Sujet=$rep['Sujet'];
                    }
                    //requète pour modifier
                    $query = "UPDATE fiche SET Nom=:Nom, Sujet=:Sujet WHERE Id =:Id";

                    //pépare requète
                    $requete=$this->Bdd->prepare($query);

                    //mettre param
                    $requete->bindParam(':Id', $Id);
                    $requete->bindParam(':Nom', $this->Nom);
                    $requete->bindParam(':Sujet', strtolower($this->Sujet));


                    //execute
                    if($requete->execute()){
                        if(isset($this->Json) && !empty($this->Json)){ //vérifie que queluqe chose dans jsno
                            //si oui, update le fichier
                            $Fichier=fopen("../../Fiches/".$Id.".json", "w"); //ouvrer et créer fichier pour cette Id
                            if($Fichier){
                                fwrite($Fichier, json_encode($this->Json));
                                fclose($Fichier);
                                return array();
                            }
                            else{
                                return array('error'=>'erreur modification fiche');    
                            }
                        }
                        return array();
                    }
                    else{
                        return array('error'=>'param invalide');
                    }
                }
                else{ //si existe pas
                    return array('error'=>'fiche existe pas');
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
        if(isset($_SESSION['Id'])){
            if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){
                //commencer par vérifier si Fiche exsite

                $query="SELECT Nom, Sujet FROM fiche WHERE Id=:Id";

                //pépare requète
                $requete=$this->Bdd->prepare($query);

                //mettre param
                $requete->bindParam(':Id', $Id);

                //execute
                $requete->execute();

                //récupère données
                $rep=$requete->fetch();

                if($rep != null){ //si existe
                    //requète pour modifier
                    $query = "DELETE FROM fiche WHERE Id=:Id";

                    //pépare requète
                    $requete=$this->Bdd->prepare($query);

                    //mettre param
                    $requete->bindParam(':Id', $Id);


                    //execute
                    if($requete->execute()){
                        $url="../../Fiches/".$Id.".json";
                        if(file_exists($url)){ 
                            unlink($url);
                        }
                        return array();
                    }
                    else{
                        return array('error'=>'param invalide');
                    }
                }
                else{ //si existe pas
                    return array('error'=>'fiche existe pas');
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
