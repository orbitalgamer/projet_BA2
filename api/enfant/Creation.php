<?php

//Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../erreur.php';
include_once '../../classes/Enfant.php';


$database = new BaseDeDonnee();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if(isset($data->Token)){
    $enfant = new Enfant($db, $data->Token);

    if(isset($data->Nom) && isset($data->Prenom) && isset($data->Annee)){

        $enfant->Nom = strtolower($data->Nom);
        $enfant->Prenom = strtolower($data->Prenom);
        $enfant->Annee = strtolower($data->Annee);
        if(isset($data->IdClasse)){
            $enfant->IdClasse = strtolower($data->IdClasse);
        }
        else{
            $enfant->IdClasse=null;
        }
        // Mettre en requête Nom : (nom du groupe)

        $retour=$enfant->newEnfant();

        if(!isset($retour['error'])){
            $rep = array('message' => "succes");
            echo json_encode($rep);
        }
        else{
            $rep = array('message' => "echec");
            $rep['error']=$retour['error'];
            erreur($rep['error']);
            echo json_encode($rep);
        }
    }
    else{
    echo json_encode(array('message' => "echec", 'error'=>'param invalide'));
    erreur('param invalide');
    }

}else{
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('param invalide');
}


?>