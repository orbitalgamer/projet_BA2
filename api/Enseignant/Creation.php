<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Enseignant.php';

//création objet bdd pour connection 
$db = New BaseDeDonnee();
//conenction
$Bdd = $db->connect();

$Prof = new Enseignant($Bdd);
//récup info
$data = json_decode(file_get_contents("php://input"));

$Prof->Nom = $data->Nom;
$Prof->Prenom = $data->Prenom;
$Prof->Email = $data->Email;
$Prof->Mdp = $data->Mdp;

//fait requète
$retour=$Prof->Creation();
if(!isset($retour['error'])){
    echo json_encode(array('message'=>'succes'));
}
else{
    $rep = array('message' => "echec");
    $rep['error']=$retour['error'];
    echo json_encode($rep);
}

?>