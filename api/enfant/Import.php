<?php

//Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../erreur.php';
include_once '../../classes/Enfant.php';
include_once '../../classes/Excel.php';


$database = new BaseDeDonnee();
$db = $database->connect();

$ExtValide = array('xlsx');

/*
pour stocker nom fichier compliqué sur plusieur personne importe en même temps
donc mets un truque bidon tant que le transfert import puis delete pour pas stocker chose useless
donc prend chiffre random comme nom
*/

$NomServeur=random_int(1, 10000000); //donné nom pour éviter colisions



if(isset($_POST['Token'])){
    if(!empty($_FILES['Fichier'])){
        //transfert fichier en première
        //remarque dans fichier dans postre créer tag fichier puis après ça dedans
        //<input type="file" name="fichier">
        $NomFichier = $_FILES['Fichier']['name'];
        $NomTmp = $_FILES['Fichier']['tmp_name'];  
        $TailleFichier = $_FILES['Fichier']['size'];

        $ExtFichier=strtolower(pathinfo($NomFichier, PATHINFO_EXTENSION)); //prend extension du fichier

        if(in_array($ExtFichier, $ExtValide)){ //verifie si bonne extension actuellement que xlsx mais pourrait être ajouté

            if($TailleFichier<50000000){ //verifie si pas plus lourd que 50Mo

                if(move_uploaded_file($NomTmp, $NomServeur.$ExtFichier)){ //envoie fichier sur serveur
                    $excel = new ImportExcel($db, $_POST['Token']);

                    //temporaire après fichier
                    $retour =$excel->Import($NomServeur.$ExtFichier);

                    if(!isset($retour['error'])){
                        echo json_encode(array('message'=>'succes'));
                        unlink($NomServeur.$ExtFichier); //supprime le fichier pour pas stocker donnée innutile
                    }
                    else{
                        $rep = array('message' => "echec");
                        $rep['error']=$retour['error'];
                        erreur($rep['error']);
                        echo json_encode($rep);
                        unlink($NomServeur.$ExtFichier); //supprime le fichier pour pas stocker donnée innutile
                    }
                }

                //après gestion erreur pour quand pas fonctionner et dire pourquoi pas fonctionner
                else{
                    echo json_encode(array('message'=>'echec','error'=>'fichier pas transmit'));
                    erreur('param invalide');
                }

            }
            else{
                echo json_encode(array('message'=>'echec','error'=>'fichier trop gros'));
                erreur('param invalide');
            }
        }else{
            echo json_encode(array('message'=>'echec','error'=>'fichier pas accepter'));
            erreur('param invalide');
        }
    }
    else{
        echo json_encode(array('message'=>'echec','error'=>'aucun fichier'));
        erreur('param invalide');
    }
    
}else{
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('param invalide');
}


?>