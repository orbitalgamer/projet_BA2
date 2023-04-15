<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Groupe.php';
include_once '../../erreur.php';

$database = new BaseDeDonnee();
$db = $database->connect();

//récup info
$data = json_decode(file_get_contents("php://input"));

if(isset($data->Token)){
    $groupe = new Groupe($Bdd, $data->Token);

    if(isset($data->Nom) && isset($_GET['Id'])){
        $groupe->Nom = $data->Nom;

        $retour=$groupe->ModifGroupe($_GET['Id']);

        if(!isset($retour['error'])){
            $rep = array('message' => "succes");
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
        echo json_encode(array('message'=>'echec', 'error'=>'param invalide'));
        erreur();
    }
}
else{
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('param invalide');
}

?>