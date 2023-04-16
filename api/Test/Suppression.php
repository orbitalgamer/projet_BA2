<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Test.php';

//création objet bdd pour connection 
$db = New BaseDeDonnee();
//conenction
$Bdd = $db->connect();

$test = new Test($Bdd);
if(isset($_GET['Id'])){ //Id doit êter définit
    $test->Id=$_GET['Id']; //lui donne Id
    $rep=$test->Delete($_GET['Id']);
    if(!isset($rep['error'])){
        echo json_encode(array('message' => 'succes'));
    }
    else{
        $retour = array('message' => "echec");
        $retour['error'] = $rep['error'];
        echo json_encode($retour);
    }
    
}else{
    $rep = array('message' => "echec", 'error'=>'id pas defini'); //ereur si Id pas défini
    echo json_encode($rep);
}

?>