<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Enseignant.php';
$db= new BaseDeDonnee();
$Bdd=$db->connect();

$Prof=new Enseignant($Bdd);

$data = json_decode(file_get_contents("php://input"));

$Prof->Identifiant = $data->Identifiant;
$Prof->Mdp = $data->Mdp;

if($Prof->Connection()){
    echo json_encode(array('message'=>'succes'));
}
else{
    echo json_encode(array('message'=>'echec'));
}

?>