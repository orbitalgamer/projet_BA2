<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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
        $retour = $enfant->Delete($_GET['Id']);

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