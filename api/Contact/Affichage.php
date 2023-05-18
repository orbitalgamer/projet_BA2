<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../bdd.php';
include_once '../../classes/Contact.php';
include_once '../../erreur.php';

//création objet bdd pour connection 
$db = New BaseDeDonnee();
//conenction
$Bdd = $db->connect();

$Contact = new Contact($Bdd, "osef car pas besoin etre connecter");

if(isset($_GET['Req'])){
    $retour =$Contact->Research(strtolower($_GET['Req']));
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
    if(isset($_GET['Id'])){
        $retour =$Contact->Read(strtolower($_GET['Id']));
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
        echo json_encode(array('message'=>'echec', 'error'=>'param invalide'));
        erreur();
}
}

?>