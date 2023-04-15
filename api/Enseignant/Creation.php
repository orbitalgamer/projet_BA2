<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
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
    //récup info


    if(isset($data->Nom) && isset($data->Prenom) && isset($data->Email) && isset($data->Mdp)){

        $Prof->Nom = $data->Nom;
        $Prof->Prenom = $data->Prenom;
        $Prof->Email = $data->Email;
        $Prof->Mdp = $data->Mdp;

        //fait requète
        $retour=$Prof->Creation();
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
        echo json_encode(array('message'=>'echec', 'error'=>'param invalide'));
        erreur();
    }
}
else{
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('param invalide');
}

?>