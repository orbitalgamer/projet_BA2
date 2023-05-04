<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
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

    if(isset($_GET['Id'])){
        if(isset($data->Nom)){
            $Contact->Nom = strtolower($data->Nom);
        }
        if(isset($data->Prenom)){
            $Contact->Prenom = strtolower($data->Prenom);
        }
        if(isset($data->Email)){
            $Contact->Email = strtolower($data->Email);
        }
        if(isset($data->Telephone)){
            $Contact->Telelphone = strtolower($data->Telephone);
        }
        if(isset($data->Description)){
            $Contact->Description = strtolower($data->Description);
        }
        if(isset($data->Specialite)){
            $Contact->Specialite = strtolower($data->Specialite);
        }
        $retour=$Contact->Update($_GET['Id']);

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
        echo json_encode(array('message'=>'echec','error'=>'param invalide'));
        erreur('param invalide');
    }

}
else{
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('param invalide');
}

?>