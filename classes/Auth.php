<?php
//permet créer des token aléatoirement et peu de chance que ça soit les même
function create_token($bytes=63, $slice=63)
 {
   $key = substr(preg_replace('/\W/', "", base64_encode(bin2hex(random_bytes($bytes)))), 0, $slice);
   return $key;
 }

class Auth{
    public $IdProf;
    public $TokenProf;
    public $DateCreation;
    private $Bdd;

    public function __construct($db){
        $this->Bdd=$db;
    }


    public function Connection($Identifiant, $Mdp){
        //requète pour rechercher nom et prenom comme c'est ça l'indetifiant
        $querry = "SELECT Id, Nom, Prenom, Email, Mdp, Admin FROM enseignant WHERE Nom= :nom AND Prenom= :prenom";

        //preparer requète
        $rq=$this->Bdd->prepare($querry);

        //mettre donné en place
        $arr=explode('.', strtolower(htmlspecialchars(strip_tags($Identifiant)))); //mets en minuscule et sépare identifiant en nom et preom
        $Nom=$arr[0];
        $Prenom=$arr[1];

        //lie paramètre prend que nom prenom pour avoir la personne
        $rq->bindParam(':nom', $Nom);
        $rq->bindParam(':prenom', $Prenom);
        //var_dump($this);
        
        //echo "SELECT Id, Nom, Prenom, Email, Mdp, Admin FROM " .$this->NomTable." WHERE Nom=".$this->Nom." AND Prenom=".$this->Prenom." AND Mdp= ".$this->Mdp;

        //execute
        $rq->execute();
        $rep=$rq->fetch();
        
        if($rep != null && password_verify($Mdp, $rep['Mdp'])){ //verifie si même mots de passe
            //regarder si possède déjà un token
            $querry="SELECT Id, IdProf,TokenProf, DateCreation FROM token WHERE IdProf=:IdProf";

            //préparer
            $requete=$this->Bdd->prepare($querry);

            //mettre param
            $requete->bindParam(':IdProf', $rep['Id']);

            //execute requète
            $requete->execute();

            //recupète les info
            $reponse=$requete->fetch();

            if($reponse != null){ //si existe, renvoie le token
                
                $retour = array();
                $retour['data']=array();
                $retour['data']['Token']=$reponse['TokenProf'];
                return $retour;
            }
            //recrée token et le mets en bdd :
            $this->TokenProf=create_token(); // créer token

            $querry="INSERT INTO token (IdProf, TokenProf) VALUES (:IdProf, :Token)"; //créer requète pour ajouter token

            $requete=$this->Bdd->prepare($querry);//prépare

            //mettre param
            $requete->bindParam(':IdProf', $rep['Id']);
            $requete->bindParam(':Token', $this->TokenProf);

            //execute requète
            if($requete->execute()){
                $retour = array();
                $retour['data']=array();
                $retour['data']['Token']=$this->TokenProf;
                return $retour;
            }else{
                return array('error creation token');
            }         
        }
        else{
            return array('error'=>'param invalide');
        }
    }

    public function VerifConnection($Token){ //vérifie si token existe et est bien de quelqu'un je sais pas opti car demande de faire requète à chaque fois mais bon pas trouvé comment mieux faire
        //crée requ!te pour retrouver Id Prof + si admin
        $querry="SELECT Prof.Id, Prof.Admin FROM token Token
        LEFT JOIN enseignant Prof
        ON Token.IdProf=Prof.Id
        WHERE Token.TokenProf=:TokenProf";

        //prepare
        $requete=$this->Bdd->prepare($querry);

        //mets param
        $requete->bindParam(':TokenProf',$Token);

        //execute
        $requete->execute();

        $rep=$requete->fetch();

        if($rep != null){
            return $rep;
        }
        else{
            return array('error'=>'pas connecter');
        }
    }

    public function Deconnection($Token){
        //supprime le token
        $querry="DELETE FROM token WHERE TokenProf=:Token";

        //prepare
        $requete=$this->Bdd->prepare($querry);

        //mets param
        $requete->bindParam(':Token',$Token);

        //execute
        if($requete->execute()){
            return array();
        }
        else{
            return array('error'=>'pas supprimer token');
        }
    }
}

?>