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
//echo "Nom = ".$data->Nom;
if(isset($data->Nom)){
    $groupe->Nom = $data->Nom;

    // Mettre en requête Nom : (nom du groupe)

    $rep=$groupe->newGroupe();

    if(!isset($rep['error'])) {
        echo json_encode(array('message' => 'succes'));
    }

    else {
        $ret=array('message' => 'echec');
        $ret['error']=$rep['error'];
        echo json_encode($ret);

    }
}
else{    
    echo json_encode(array('message' => 'echec', 'error'=>'param invalide'));
}



?>