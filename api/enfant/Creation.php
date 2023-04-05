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
    $Enfant = new Enfant($Bdd, $data->Token);

    if(isset($data->Nom) && isset($data->Prenom) && isset($data->Annee) && isset($data->IdClasse)){

        $enfant->Nom = $data->Nom;
        $enfant->Prenom = $data->Prenom;
        $enfant->Annee = $data->Annee;
        $enfant->IdClasse = $data->IdClasse;

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
    echo json_encode(array('message'=>'echec','error'=>'param invalide'));
    erreur('param invalide');
}


?>