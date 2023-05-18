<?php
//amen
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Auth.php';
$db= new BaseDeDonnee();
$Bdd=$db->connect();

$conn=new Auth($Bdd);

$data = json_decode(file_get_contents("php://input"));

if(isset($data->Identifiant) && isset($data->Mdp)){

    $retour =$conn->Connection(strtolower($data->Identifiant), $data->Mdp);
    if(!isset($retour['error'])){
        $rep=array('message'=>'succes');
        $rep['data']=$retour['data'];
        echo json_encode($rep);
        http_response_code(200);
    }
    else{
        $rep =array('message'=>'echec');
        $rep['error']=$retour['error'];
        echo json_encode($rep);
        http_response_code(403);
    }
}
else{
    echo json_encode(array('message'=>'echec', 'error'=>'param invalide'));
}


?>