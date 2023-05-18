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

$data = json_decode(file_get_contents("php://input"));
if(isset($data->Token)){
    if(isset($data->IdEleve) && isset($data->ScoreTDA) && isset($data->ScoreDyslexie) && isset($data->ScoreDysortho)){
        $test = new Test($db, $data->Token);

        //get input
        $test->IdEleve = strtolower($data->IdEleve);
        $test->ScoreTDA = $data->ScoreTDA;
        $test->ScoreDyslexie = $data->ScoreDyslexie;
        $test->ScoreDysortho = $data->ScoreDysortho;

        $rep=$test->Create();

        if(!isset($rep['error'])) {
            echo json_encode(array('message' => 'succes'));
        }

        else {
            $ret=array('message' => 'echec');
            $ret['error']=$rep['error'];
            echo json_encode($ret);
            erreur($ret['error']);
        }    
    }
    else{
        echo json_encode(array('message'=>'echec','error'=>'param invalide'));
        erreur('token invalide');
    }
}
else{
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('token invalide');
}


?>