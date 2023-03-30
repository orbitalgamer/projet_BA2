<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Enfant.php';

//création objet bdd pour connection 
$db = New BaseDeDonnee();
//conenction
$Bdd = $db->connect();

$enfant = new Enfant($Bdd);


if(isset($_GET['Id'])){
    $retour = $enfant->Delete($_GET['Id']);

    if(!isset($retour['error'])){
        echo json_encode(array('message'=>'succes'));
    }
    else{
        $rep = array('message' => "echec");
        $rep['error']=$retour['error'];
        echo json_encode($rep);
    }
}
else{
    echo json_encode(array('message'=>'echec','error'=>'param invalide'));
}



?>