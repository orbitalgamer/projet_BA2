<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Fiche.php';

//création objet bdd pour connection 
$db = New BaseDeDonnee();
//conenction
$Bdd = $db->connect();

$Fiche = new Fiche($Bdd);
//récup info
$data = json_decode(file_get_contents("php://input"));

if(isset($data->Nom) && isset($data->Sujet) && isset($data->Json)){

    $Fiche->Nom = $data->Nom;
    $Fiche->Sujet = $data->Sujet;
    $Fiche->Json = $data->Json;

    //fait requète
    $retour=$Fiche->Create();
    if(!isset($retour['error'])){
        echo json_encode(array('message'=>'succes'));
    }
    else{
        $rep = array('message' => "echec");
        $rep['error']=$retour['error'];
        echo json_encode($rep);
    }
}
else{
    echo json_encode(array('message'=>'echec', 'error'=>'param invalide'));
}

?>