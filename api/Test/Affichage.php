<?php

//Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Test.php';
include_once '../../erreur.php';

$database = new BaseDeDonnee();
$db = $database->connect();



//get input
$data = json_decode(file_get_contents("php://input"));


if(isset($data->Token)){
    $test = new Test($db, $data->Token);
    if(isset($_GET['Id'])){

        $rep=$test->RecupIdTest($_GET['Id']);
    }

    else if (isset($_GET['IdEleve'])) {

        if(isset($_GET['AllProf'])){
            $rep=$test->RecupEnfantTest($_GET['IdEleve'], $_GET['AllProf']);
        }
        else{
            $rep=$test->RecupEnfantTest($_GET['IdEleve']);
        }

    }
    else if (isset($_GET['IdProf'])) {
        $rep=$test->RecupProfTest($_GET['IdProf']);

    } 
    else if(isset($_GET['Req'])){
        $rep=$test->Recherche($_GET['Req']);        
    }
    else{
        echo json_encode(array('message'=>'echec','error'=>'param invalide'));
        erreur('param invalide');
    }

    if(!isset($rep['error'])) {
        $retour=array('message' => 'succes');
        $retour['data']=$rep['data'];
        echo json_encode($retour);
    }

    else {
        $ret=array('message' => 'echec');
        $ret['error']=$rep['error'];
        echo json_encode($ret);
    }
}
else{
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('token invalide');
}

?>