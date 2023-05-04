<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Contact.php';
include_once '../../erreur.php';

//création objet bdd pour connection 
$db = New BaseDeDonnee();
//conenction
$Bdd = $db->connect();


//récup info
$Data = json_decode(file_get_contents("php://input"));

if(isset($Data->Token)){
    $Contact = new Contact($Bdd, $Data->Token);
    
    if(isset($_GET['Id']) && !empty($_GET['Id'])){   
        $rep=$Contact->Delete($_GET['Id']);
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
        echo json_encode(array('message'=>'echec','error'=>'param invalide'));
        erreur('param invalide');
    }

}
else{
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('param invalide');
}

?>