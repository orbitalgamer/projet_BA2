<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Enseignant.php';
include_once '../../erreur.php';

//création objet bdd pour connection 
$db = New BaseDeDonnee();
//conenction
$Bdd = $db->connect();

$data = json_decode(file_get_contents("php://input"));
if(isset($data->Token)){
    $Prof = new Enseignant($Bdd, $data->Token);
    if(isset($_GET['Id'])){ //Id doit êter définit
        $Prof->Id=$_GET['Id']; //lui donne Id
        $rep=$Prof->Supprimer();
        if(!isset($rep['error'])){
            echo json_encode(array('message' => 'succes'));
        }
        else{
            $retour = array('message' => "echec");
            $retour['error']=$rep['error'];
            erreur($retour['error']);
            echo json_encode($retour);
        }
        
    }else{
        $rep = array('message' => "echec", 'error'=>'id pas defini'); //ereur si Id pas défini
        erreur();
        echo json_encode($rep);
    }
}
else{
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('param invalide');
}

?>