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

$data = json_decode(file_get_contents("php://input"));

if(isset($data->Token)){
    $excel = new ImportExcel($db, $data->Token);

    //temporaire après fichier
    $retour =$excel->Import($data->url);

    if(!isset($retour['error'])){
        echo json_encode(array('message'=>'succes'));
    }
    else{
        $rep = array('message' => "echec");
        $rep['error']=$retour['error'];
        erreur($rep['error']);
        echo json_encode($rep);
    }
    
}else{
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('param invalide');
}


?>