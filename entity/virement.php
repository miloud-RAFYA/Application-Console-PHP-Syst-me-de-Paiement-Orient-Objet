<?php
require_once __DIR__ . '/paiement.php';

class Virement extends Paiement {
    private $bank_name; 
    private $iban; 

    public function __construct($statut, $montant, $bank_name, $iban){
        parent::__construct($statut, $montant);
        $this->bank_name = $bank_name;
        $this->iban = $iban;
    }

    
    public function __get($name){
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    } 
    
    public function __set($name, $value){
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

   
    public function setBankName($bank_name) {
        $this->bank_name = $bank_name;
    }
    
    public function setIban($iban) {
        $this->iban = $iban;
    }
    
    public function getBankName() {
        return $this->bank_name;
    }
    
    public function getIban() {
        return $this->iban;
    }
    
    public function setCommande($commande){
        $this->commande = $commande;
    }
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function setMontant($montant) {
        $this->montant = $montant;
    }
    
    public function setStatut($statut) {
        $this->statut = $statut;
    }
}
?>