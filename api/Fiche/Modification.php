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
    $fiche = new Fiche($Bdd, $_POST['Token']);

    if(isset($_GET['Id'])){ //regarde si on a un Id
        //set ce qu'on a défini de nouveau ainsi pas besoin de redire tout le reste
        if(isset($_POST['Nom'])){
            $fiche->Nom = strtolower(htmlspecialchars(strip_tags($_POST['Nom'])));
        }
        if(isset($_POST['Sujet'])){
            $fiche->Sujet = strtolower(htmlspecialchars(strip_tags($_POST['Sujet'])));
        }
    //encore faire système upload
    
        $retour = $fiche->Update($_GET['Id']);

        if(isset($retour['data']['upload']) && !empty($_FILES['Fichier'])){
            
            $NomServeur=$retour['data']['Id'];//mets le nom stocker sur le serveur
            $NomFichier = $_FILES['Fichier']['name']; //prend le nom actuel même si va l'écraser par après
            $NomTmp = $_FILES['Fichier']['tmp_name'];  //prend nom temporaire avant que stocker définit dans serveur
            $TailleFichier = $_FILES['Fichier']['size']; //prend taille fichier

            $ExtFichier=strtolower(pathinfo($NomFichier, PATHINFO_EXTENSION)); //prend extension du fichier

            if(in_array($ExtFichier, $ExtValide)){ //verifie si bonne extension actuellement que xlsx mais pourrait être ajouté

                if($TailleFichier<10000000){ //verifie si pas plus lourd que 10Mo

                    if(file_exists( "../../Fiches/".$NomServeur.".".$ExtFichier)){ //supprime l'ancien fichier si existe
                        unlink( "../../Fiches/".$NomServeur.".".$ExtFichier);
                    }
                    
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

        if(!isset($retour['error'])){
            echo json_encode(array('message'=>'succes'));
        }
        else{
            $rep = array('message' => "echec");
            $rep['error']=$retour['error'];
            echo json_encode($rep);
            erreur($rep['error']);
        }
    }
    else{
        erreur();
        echo json_encode(array('message'=>"echec", "error"=>"param invalide"));
    }
}
else{
   
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('param invalide');
}

?>