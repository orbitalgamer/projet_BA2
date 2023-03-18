<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Enseignant.php';

//création objet bdd pour connection 
$db = New BaseDeDonnee();
//conenction
$Bdd = $db->connect();

$Prof = new Enseignant($Bdd);
if(isset($_GET['Id'])){ //Id doit êter définit
    $Prof->Id=$_GET['Id']; //lui donne Id
    $rep=$Prof->Supprimer();
    if(!isset($rep['error'])){
        echo json_encode(array('message' => 'succes'));
    }
    else{
        $rep = array('message' => "echec");
        $rep['error']=$retour['error'];
        echo json_encode($rep);
    }
    
}else{
    $rep = array('message' => "echec", 'error'=>'id pas defini'); //ereur si Id pas défini
    echo json_encode($rep);
}

?>