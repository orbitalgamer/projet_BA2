<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Enseignant.php';
include_once '../../erreur.php';

//création objet bdd pour connection 
$db = New BaseDeDonnee();
//conenction
$Bdd = $db->connect();

$Prof = new Enseignant($Bdd);
if(isset($_GET['Id'])){
    $Id=$_GET['Id']; //prend Id qu'on travail
    
}else{
    $Id=-42; //osef car sécurité derrière qui fera que peut modifier que le sien
}

$data = json_decode(file_get_contents("php://input"));
//set ce qu'on a défini de nouveau ainsi pas besoin de redire tout le reste
if(isset($data->Nom)){
    $Prof->Nom = strtolower(htmlspecialchars(strip_tags($data->Nom)));
}
if(isset($data->Prenom)){
    $Prof->Prenom = strtolower(htmlspecialchars(strip_tags($data->Prenom)));
}
if(isset($data->Email)){
    $Prof->Email = strtolower(htmlspecialchars(strip_tags($data->Email)));
}
if(isset($data->Mdp)){
    $Prof->Mdp = strtolower(htmlspecialchars(strip_tags($data->Mdp)));
}
if(isset($data->Admin)){
    $Prof->Admin = strtolower(htmlspecialchars(strip_tags($data->Admin)));
}

$retour = $Prof->Modifier($Id);

if(!isset($retour['error'])){
    echo json_encode(array('message'=>'succes'));
}
else{
    $rep = array('message' => "echec");
    $rep['error']=$retour['error'];
    echo json_encode($rep);
    erreur($rep['error']);
}

?>