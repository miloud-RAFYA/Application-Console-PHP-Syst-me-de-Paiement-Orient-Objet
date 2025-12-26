<?php
require_once __DIR__ . "/../entity/client.php";
class commade
{

    public $montant_total;
    public $statut;
    public client $client;


    public function __construct($montant_total, $statut,client $client)
    {
        $this->montant_total = $montant_total;
        $this->statut = $statut;
        $this->client =$client;
    }

    public function setmontat_total($montant_total)
    {
        $this->montant_total = $montant_total;

    }
    public function setstatut($statut)
    {
        $this->statut = $statut;
    }
    public function getmontat_total()
    {
        return$this->montant_total;

    }
    public function getstatut()
    {
        return$this->statut;

    }
   
    public function __toString()
    {
        return "le montat total de commande est :" . $this->montant_total . " et statut :" . $this->statut;
    }
}



