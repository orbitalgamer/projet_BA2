<?php

//Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Test.php';


$database = new BaseDeDonnee();
$db = $database->connect();
$test = new Test($db);


//get input
$data = json_decode(file_get_contents("php://input"));

    $test->IdProf = $data->IdProf;
    $test->IdEleve = $data->IdEleve;
    $test->ScoreTDA = $data->ScoreTDA;
    $test->ScoreDyslexie = $data->ScoreDyslexie;
    $test->ScoreDysortho = $data->ScoreDysortho;

    $rep=$test->creaTest();

    if(!isset($rep['error'])) {
        echo json_encode(array('message' => 'succes'));
    }

    else {
        $ret=array('message' => 'echec');
        $ret['error']=$rep['error'];
        echo json_encode($ret);

    }


?>