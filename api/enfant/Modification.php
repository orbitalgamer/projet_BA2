<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Enfant.php';
include_once '../../erreur.php';

//création objet bdd pour connection 
$db = New BaseDeDonnee();
//conenction
$Bdd = $db->connect();

$data = json_decode(file_get_contents("php://input"));

if(isset($data->Token)){
    $Enfant = new Enfant($Bdd, $data->Token);

    if(isset($_GET['Id'])){
        $Id=$_GET['Id']; //prend Id qu'on travail

        //set ce qu'on a défini de nouveau ainsi pas besoin de redire tout le reste
        if(isset($data->Nom)){
            $Enfant->Nom = strtolower(htmlspecialchars(strip_tags($data->Nom)));
        }
        if(isset($data->Prenom)){
            $Enfant->Prenom = strtolower(htmlspecialchars(strip_tags($data->Prenom)));
        }
        if(isset($data->Annee)){
            $Enfant->Annee = strtolower(htmlspecialchars(strip_tags($data->Annee)));
        }
        if(isset($data->IdClasse)){
            $Enfant->IdClasse = strtolower(htmlspecialchars(strip_tags($data->IdClasse)));
        }

        $retour = $Enfant->Update($Id);

        if(!isset($retour['error'])){
            echo json_encode(array('message'=>'succes'));
        }
        else{
            $rep = array('message' => "echec");
            $rep['error']=$retour['error'];
            erreur($rep['error']);
            echo json_encode($rep);
        }
    }
    else{
        echo json_encode(array('message'=>'echec','error'=>'param invalide'));
        erreur();
    }
}
else{
    echo json_encode(array('message'=>'echec','error'=>'param invalide'));
    erreur('param invalide');
}


?>