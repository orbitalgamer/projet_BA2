<?php


//dépendance pour
require_once 'Auth.php'; //pour vérifier que connecté
require_once 'Enfant.php';
require_once 'Groupe.php';
require_once "../../Excel/Lecture/PHPExcel.php";

class ImportExcel {
    
    private $Enfant;
    private $Bdd;
    private $Groupe;


    //Requête création groupe

    public function __construct($db, $Token) {
        $this->Bdd = $db;

        $auth = New Auth($db); //créer objet auth
        $reponse = $auth->VerifConnection($Token); //verifie si connecté
        if(!isset($reponse['error'])){ //remets en variable session pour leur requète qui plante
            $_SESSION['Id']=$reponse['Id'];
            $_SESSION['Admin']=$reponse['Admin'];
        }
        $this->Enfant = New Enfant($this->Bdd,'osef toke car session');
        $this->Groupe = New Groupe($this->Bdd,'osef toke car session');
    }
    
    public function Import($url){
        if($_SESSION['Id']){
            if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true){
                //fonction pour importer excel

                $reader = PHPExcel_IOFactory::createReaderForFile($url); // crée objet lecture
                $ObjetExcel = $reader->load($url);

                $feuille = $ObjetExcel->getActiveSheet(); // lit la feuille en question

                $NombreLigne = $feuille->getHighestRow(); //prend nombre  ligne
                //$NombreColonne = PHPExcel_Cell::columnIndexFromString($feuille->getHighetDataColumn());  //prend nombre de colonne
                
                $EnfantInput=array();//pour placer à chaque lecture

                $Classe = array(); // pour stocker toutes les classes

                if(strtolower($feuille->getCell("A1")) =="nom" && strtolower($feuille->getCell("B1")) =="prenom" && strtolower($feuille->getCell("C1")) =="annee" && strtolower($feuille->getCell("D1")) =="nom de la classe"){ //verifie bien qu'on mis le template en regardant les case en haut pour pas avoir des mauvais fichier

                    //passe tout les ligne
                    for($row=2;$row<=$NombreLigne;$row++){
                        $EnfantInput['Nom']=strtolower($feuille->getCell("A".$row));
                        $EnfantInput['Prenom']=strtolower($feuille->getCell("B".$row));
                        $EnfantInput['Annee']=strtolower($feuille->getCell("C".$row));
                        $EnfantInput['NomClasse']=strtolower($feuille->getCell("D".$row));

                        if(empty($EnfantInput['Nom']) && empty($EnfantInput['Prenom']) && empty($EnfantInput['Annee']) ){
                            continue; //verifie si vas case vide glisse entre ttou
                        }
                        
                        if(isset($Classe[$EnfantInput['NomClasse']]) && !empty($Classe[$EnfantInput['NomClasse']])){ //recherche si classe exsite
                            $EnfantInput['IdClasse']=$Classe[$EnfantInput['NomClasse']];
                        }
                        else{
                            //si classe pas connu, recheche si exise sinon alors
                            $Rq=$this->Groupe->Recherche($EnfantInput['NomClasse']); //fait requète
                            if(!isset($Rq['error']) && !empty($Rq['data'])){
                                $Classe[$Rq['data'][0]['Nom']]=$Rq['data'][0]['Id'];
                                $EnfantInput['IdClasse'] = $Rq['data'][0]['Id'];
                            }
                            else{
                                $EnfantInput['IdClasse'] = null;
                            }
                        }

                        //crée nouveau enfant
                        $this->Enfant->Nom=$EnfantInput['Nom'];
                        $this->Enfant->Prenom=$EnfantInput['Prenom'];
                        $this->Enfant->Annee=$EnfantInput['Annee'];
                        $this->Enfant->IdClasse=$EnfantInput['IdClasse'];
                        $this->Enfant->newEnfant();
                        
                    }
                    return array(); //retourne que tout c'est bien passé
                    }
                    else{
                        return array('error'=>'fichier invalide');
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

    //fonction pour transferer fichier
    public function Transfert(){
        
    }

}

?>