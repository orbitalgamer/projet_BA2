<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../bdd.php';
include_once '../../classes/Fiche.php';

//création objet bdd pour connection 
$db = New BaseDeDonnee();
//conenction
$Bdd = $db->connect();

$Fiche = new Fiche($Bdd);
//récup info

if(isset($_GET['Id'])){
    $retour =$Fiche->Read($_GET['Id']);
    if(!isset($retour['error'])){
        $rep = array('message' => "succes");
        $rep['data']= $retour['data'];
        echo json_encode($rep);
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