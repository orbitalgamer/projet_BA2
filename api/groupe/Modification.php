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

if(isset($data->Nom) && isset($_GET['Id'])){
    $groupe->Nom = $data->Nom;
    $groupe->Id = $_GET['Id'];

    if($groupe->ModifGroupe()) {

        echo json_encode(
            array('message' => 'succes')
        );
    }

    else {
        echo json_encode(
            array('message' => 'echec')
        );
    }
}
else{
    echo json_encode(array('message'=>'echec', 'error'=>'param invalide'));
}

?>