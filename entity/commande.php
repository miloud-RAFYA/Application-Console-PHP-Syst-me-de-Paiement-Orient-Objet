<?php
require_once __DIR__ . "/../entity/client.php";
class commande
{

    private $id;
    private  $montant_total;
    private $statut;
    private client $client;


    public function __construct($montant_total, $statut)
    {
        $this->montant_total = $montant_total;
        $this->statut = $statut;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setClient($client)
    {
        $this->client = $client;
    }
    public function __get($name)
    {
        return$this->$name;

    }  
    public function __toString()
    {
        return "le nemuro est : ".$this->id."  le montat total  est : " . $this->montant_total . " et statut : " . $this->statut."de client : ".$this->client->name."\n";
    }
}



