<?php

//Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../bdd.php';
include_once '../../classes/Enfant.php';


$database = new BaseDeDonnee();
$db = $database->connect();
$enfant = new Enfant($db);


//get input
$data = json_decode(file_get_contents("php://input"));
//echo "Nom = ".$data->Nom;
$enfant->Nom = $data->Nom;
$enfant->Prenom = $data->Prenom;
$enfant->Annee = $data->Annee;
$enfant->IdClasse = $data->IdClasse;

// Mettre en requête Nom : (nom du groupe)

if($enfant->newEnfant()) {

    echo json_encode(
        array('message' => 'Enfant ajoute !')
    );
}

else {

    echo json_encode(
        array('message' => 'Echec de l'ajout de l'enfant')
    );
}




?>