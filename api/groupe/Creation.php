<?php

//Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Groupe.php';


$database = new BaseDeDonnee();
$db = $database->connect();
$groupe = new Groupe($db);


//get input
$data = json_decode(file_get_contents("php://input"));

$Groupe->Nom = $data->Nom;
// Mettre en requête Nom : (nom du groupe)

if($Groupe->newGroupe()) {

    echo json_encode(
        array('message' => 'Groupe cree !');
    )
}

else {

    echo json_encode(
        array('message' => 'Echec de la creation du groupe');
    )
}



?>