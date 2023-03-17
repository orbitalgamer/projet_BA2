<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Groupe.php';

$database = new BaseDeDonnee();
$db = $database->connect();
$groupe = new Groupe($db);

$data = json_decode(file_get_contents("php://input"));
$groupe->Nom = $data->Nom;
$groupe->Id = $data->Id;

if($groupe->ModifGroupe()) {

    echo json_encode(
        array('message' => 'Nom du groupe modifie !')
    );
}

else {

    echo json_encode(
        array('message' => 'Echec de la modification')
    );
}

?>