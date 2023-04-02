<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Groupe.php';
include_once '../../erreur.php';

//création objet bdd pour connection 
$db = New BaseDeDonnee();
//conenction
$Bdd = $db->connect();

$Groupe = new Groupe($Bdd);

$Data = json_decode(file_get_contents("php://input"));

//défini var à par de défaut fct
$IdProf=-42;
$IdClasse=-42;

//doit savoir si veut que désalouer ou supprimer
if(isset($Data->Desalouer)){

    //si veut que désalouer
    if($Data->Desalouer == true){    
        //regarde le quel des deux est mits si aucun erreur viens de fct
        if(isset($Data->IdProf)){
            $IdProf=$Data->IdProf;
        }
        if(isset($Data->IdClasse)){
            $IdClasse=$Data->IdClasse;
        }
        $rep=$Groupe->Desalouer($IdProf, $IdClasse);
    }
    //si veux supprimer
    else if($Data->Desalouer == false && isset($Data->IdClasse)){
        $rep=$Groupe->DeleteClasse($Data->IdClasse);
    }
    //si pas mis les bon param pour supprimer
    else{
        $rep['error']="param invalide";
    }
    
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
    erreur();
    echo json_encode(array('message'=>'echec', 'error'=>'param invalide'));
}


    

/*else{
    $rep = array('message' => "echec", 'error'=>'id pas defini'); //ereur si Id pas défini
    echo json_encode($rep);
}*/

?>