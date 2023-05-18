<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../bdd.php';
include_once '../../classes/Groupe.php';
include_once '../../erreur.php';

//création objet bdd pour connection 
$db = New BaseDeDonnee();
//conenction
$Bdd = $db->connect();

//récup info
$data = json_decode(file_get_contents("php://input"));

if(isset($data->Token)){
    $Groupe = new Groupe($Bdd, $data->Token);

    if(isset($_GET['Req'])){
        $retour =$Groupe->Recherche(strtolower($_GET['Req']));
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
        if(isset($data->IdProf) && isset($data->IdClasse) && isset($data->Eleve)){
            $retour =$Groupe->Selectionner(strtolower($data->IdProf), strtolower($data->IdClasse), strtolower($data->Eleve));
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
}
else{
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('param invalide');
}
?>