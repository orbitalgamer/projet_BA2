<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Fiche.php';
include_once '../../erreur.php';

//création objet bdd pour connection 
$db = New BaseDeDonnee();
//conenction
$Bdd = $db->connect();

$ExtValide = array('pdf');

if(isset($_POST['Token'])){
    $Fiche = new Fiche($Bdd, $_POST['Token']);
    
    if(isset($_POST['Nom']) && isset($_POST['Sujet']) && !empty($_FILES['Fichier'])){

        $Fiche->Nom = strtolower($_POST['Nom']);
        $Fiche->Sujet = strtolower($_POST['Sujet']);

        //fait requète
        $retour=$Fiche->Create();
        if(!isset($retour['error'])){
            if($retour['upload']=="upload"){
                $NomServeur=$retour['data']['Id'];//mets le nom stocker sur le serveur
                $NomFichier = $_FILES['Fichier']['name']; //prend le nom actuel même si va l'écraser par après
                $NomTmp = $_FILES['Fichier']['tmp_name'];  //prend nom temporaire avant que stocker définit dans serveur
                $TailleFichier = $_FILES['Fichier']['size']; //prend taille fichier

                $ExtFichier=strtolower(pathinfo($NomFichier, PATHINFO_EXTENSION)); //prend extension du fichier

                if(in_array($ExtFichier, $ExtValide)){ //verifie si bonne extension actuellement que xlsx mais pourrait être ajouté

                    if($TailleFichier<10000000){ //verifie si pas plus lourd que 10Mo
                        
                        if(move_uploaded_file($NomTmp, "../../Fiches/".$NomServeur.".".$ExtFichier)){ //envoie fichier sur serveur
                        }
                        else{
                            echo json_encode(array('message'=>'echec', 'error'=>'fichier pas transmit'));
                            die();
                        }
                    }
                    else{
                        echo json_encode(array('message'=>'echec', 'error'=>'fichier trop gros'));
                        die();
                    }
                }
                else{
                    echo json_encode(array('message'=>'echec', 'error'=>'fichier pas valide'));
                    die();
                }
            }
            else{
                echo json_encode(array('message'=>'echec', 'error'=>'fichier pas transmit'));
                die();
            }
            echo json_encode(array('message'=>'succes'));
        }
        else{//erreur de retour de la classe
            $rep = array('message' => "echec");
            $rep['error']=$retour['error'];
            echo json_encode($rep);
        }
    }
    else{
        echo json_encode(array('message'=>'echec', 'error'=>'param invalide'));
    }
}
else{
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('param invalide');
}

?>