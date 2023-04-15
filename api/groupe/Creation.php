<?php

//Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Groupe.php';
include_once '../../erreur.php';


$database = new BaseDeDonnee();
$db = $database->connect();

//récup info
$data = json_decode(file_get_contents("php://input"));

if(isset($data->Token)){
    $Groupe = new Groupe($Bdd, $data->Token);
    
    if(isset($data->Allocation) && $data->Allocation==true){
        //si veux allouer
        if(isset($data->IdProf) && isset($data->IdClasse)){

            //faire requète
            
            $retour=$groupe->Allouer($data->IdProf,$data->IdClasse);
            //gestion erreur
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
            echo json_encode(array('message'=>'echec', 'error'=>'param invalide'));
            erreur();
            die();
        }
    }
    else{
        //si veux créer classe
        if(isset($data->Nom)){
            $groupe->Nom = $data->Nom;
        
            // Mettre en requête Nom : (nom du groupe)
        
            $rep=$groupe->newGroupe();
        
            if(!isset($rep['error'])) {
                echo json_encode(array('message' => 'succes'));
            }
        
            else {
                $ret=array('message' => 'echec');
                $ret['error']=$rep['error'];
                erreur($ret['error']);
                echo json_encode($ret);
        
            }
        }
        else{    
            echo json_encode(array('message' => 'echec', 'error'=>'param invalide'));
            erreur();
        }
        
    }
}
else{
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('param invalide');
}


?>