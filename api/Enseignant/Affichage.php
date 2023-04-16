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


//récup info
$data = json_decode(file_get_contents("php://input"));

if(isset($data->Token)){
$Prof = new Enseignant($Bdd, $data->Token);

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
    else if(isset($_GET['Req'])){
        $retour =$Prof->Rechercher($_GET['Req']);
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
}else{
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('param invalide');
}
?>