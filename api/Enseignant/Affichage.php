<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../bdd.php';
include_once '../../classes/Enseignant.php';
include_once '../../erreur.php';

//création objet bdd pour connection 
$db = New BaseDeDonnee();
//conenction
$Bdd = $db->connect();

$Prof = new Enseignant($Bdd);
//récup info
$data = json_decode(file_get_contents("php://input"));

if(isset($_GET['Id'])){
    $retour =$Prof->Selectionner($_GET['Id']);
    if(!isset($retour['error'])){
        $rep = array('message' => "succes");
        $rep['data']= $retour['data'];
        echo json_encode($rep);
    }
    else{
        $rep = array('message' => "echec");
        $rep['error']=$retour['error'];
        erreur($rep['error']);
        echo json_encode($rep);
    }
}
else{
    $retour =$Prof->Selectionner();
    if(!isset($retour['error'])){
        $rep = array('message' => "succes");
        $rep['data']= $retour['data'];
        echo json_encode($rep);
    }
    else{
        $rep = array('message' => "echec");
        $rep['error']=$retour['error'];
        erreur($rep['error']);
        echo json_encode($rep);
    }
}
?>