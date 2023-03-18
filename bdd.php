<?php
    session_start();
    class BaseDeDonnee{
        //var privé pour config la connection
        private $host='localhost';
        private $NomBdd='projetba2';
        private $NomBdd='projetba2';
        private $user='root';
        private $Mdp='';
        private $lienBdd;

        public function connect() { //var connecter
            if(isset($_SESSION['Bdd'])){
                return $_SESSION['Bdd'];
            }
            
            try{ //essaye de se connecter avec param au dessus
                $this->lienBdd= new PDO('mysql:host='.$this->host.';dbname='.$this->NomBdd,$this->user, $this->Mdp);
            } catch(exception $e){ //si erreur, les affiche et stopper programme
                die('erreur : '.$e->getMessage());
            }
            return $this->lienBdd; //return objet bdd
        }

    }

?>
