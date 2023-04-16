<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Fiche.php';
include_once '../../erreur.php';

//création objet bdd pour connection 
$db = New BaseDeDonnee();
//conenction
$Bdd = $db->connect();

//récup info
$data = json_decode(file_get_contents("php://input"));
if(isset($data->Token)){
    $fiche = new Fiche($Bdd, $data->Token);

    if(isset($_GET['Id'])){ //regarde si on a un Id
        //set ce qu'on a défini de nouveau ainsi pas besoin de redire tout le reste
        if(isset($data->Nom)){
            $fiche->Nom = strtolower(htmlspecialchars(strip_tags($data->Nom)));
        }
        if(isset($data->Sujet)){
            $fiche->Sujet = strtolower(htmlspecialchars(strip_tags($data->Sujet)));
        }
        if(isset($data->Json)){
            $fiche->Json = $data->Json;
        }
    
        $retour = $fiche->Update($_GET['Id']);

        if(!isset($retour['error'])){
            echo json_encode(array('message'=>'succes'));
        }
        else{
            $rep = array('message' => "echec");
            $rep['error']=$retour['error'];
            echo json_encode($rep);
            erreur($rep['error']);
        }
    }
    else{
        erreur();
        echo json_encode(array('message'=>"echec", "error"=>"param invalide"));
    }
}
else{
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('param invalide');
}

?>