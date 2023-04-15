<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../bdd.php';
include_once '../../classes/Enfant.php';
include_once '../../erreur.php';

//création objet bdd pour connection 
$db = New BaseDeDonnee();
//conenction
$Bdd = $db->connect();

//récup info
$data = json_decode(file_get_contents("php://input"));

if(isset($data->Token)){
    $Enfant = new Enfant($Bdd, $data->Token);

    $IdClasse='None';

    if(isset($_SESSION['Id'])){
        $IdProf=$_SESSION['Id'];
    }
    else{
        echo json_encode(array('message'=>'echec', 'error'=>'pas connecter'));
        erreur('pas connecter');
        die();
    }

    if(isset($_GET['Id'])){
        $retour =$Enfant->SelectionnerEnfant($_GET['Id']);
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
        $retour =$Enfant->Recherche($_GET['Req']);
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
        if(isset($data->IdClasse)){
            $IdClasse=$data->IdClasse;
        }
        if(isset($data->IdProf)){
            $IdProf=$data->IdProf;
        }

        $retour = $Enfant->Selectionner($IdClasse, $IdProf);
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
}
else{
    echo json_encode(array('message'=>'echec','error'=>'token invalide'));
    erreur('param invalide');
}
?>