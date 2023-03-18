<?php



class Test{

    public $Id;
    public $IdProf;
    public $IdEnfant;
    public $Date;
    public $ScoreTDA;
    public $ScoreDyslexie;
    public $ScoreDysortho;

    public function creaTest() {

        $query = "INSERT INTO test (Id, IdProf, IdEleve, Date, ScoreTDA, ScoreDyslexie, ScoreDysortho) 
        VALUES ('','','','','','','')";



    }


}



?>