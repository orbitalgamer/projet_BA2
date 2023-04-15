<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Test.php';
include_once '../../erreur.php';

//création objet bdd pour connection 
$db = New BaseDeDonnee();
//conenction
$Bdd = $db->connect();


//récup info
$data = json_decode(file_get_contents("php://input"));

if(isset($data->Token)){
    $test = new Test($Bdd, $data->Token);

        if(isset($data->Id)){
            $rep=$test->DeleteId($data->Id);
        }
        else if(isset($data->IdEleve)){
            $rep=$test->DeleteIdEleve($data->IdEleve);
        }
        else if(isset($data->IdProf)){
            $rep=$test->DeleteIdProf($data->IdProf);
        }
        else{
            erreur();
            echo json_encode(array('message'=>'echec', 'error'=>'param invalide'));
            die();
        }
    
    
        //renvoier état si réussi ou echec avec erreur
        if(!isset($rep['error'])){
            echo json_encode(array('message' => 'succes'));
        }
        else{
            $retour = array('message' => "echec");
            $retour['error']=$rep['error'];
            erreur($retour['error']);
            echo json_encode($retour);
        }


}
else{
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('param invalide');
}

?>