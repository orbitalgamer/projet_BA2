<?php

//Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Contact.php';
include_once '../../erreur.php';


$database = new BaseDeDonnee();
$db = $database->connect();

//récup info
$data = json_decode(file_get_contents("php://input"));

if(isset($data->Token)){
    $Contact = new Contact($db, $data->Token);
    if(isset($data->Nom) && isset($data->Prenom) && isset($data->Email) && isset($data->Specialite)){ //regarde si tous les param sont mits

        $Contact->Nom=$data->Nom;
        $Contact->Prenom=$data->Prenom;
        $Contact->Email=$data->Email;
        if(isset($data->Description)){
            $Contact->Description=$data->Description;
        }
        else{
            $Contact->Description = null;
        }
        $Contact->Specialite=$data->Specialite;
        if(isset($data->Telephone)){
            $Contact->Telelphone=$data->Telephone; //je sais faute de frappe de l'autre côté dans la classe et dans la db
        }
        else{
            $Contact->Telelphone=null;
        }

        $retour = $Contact->Create();
        if(!isset($retour['error'])){
            $rep = array('message' => "succes");
            echo json_encode($rep);
        }
        else {
            $ret=array('message' => 'echec');
            $ret['error']=$retour['error'];
            erreur($ret['error']);
            echo json_encode($ret);

        }
    }
    else{
        echo json_encode(array('message'=>'echec','error'=>'param invalide'));
        erreur('param invalide');
    }
}
else{
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('param invalide');
}


?>