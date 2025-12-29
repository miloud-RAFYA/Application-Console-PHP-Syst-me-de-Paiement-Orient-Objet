<?php
class Paypal extends Paiement {

    
    private $paypal_email; 
    private $account_type; 


    public function __construct($statut,$montant, $paypal_email, $account_type){
        parent :: __construct($statut,$montant);
        $this->paypal_email=$paypal_email;
        $this->account_type=$account_type;
    }

    public function __get($id){
         return $this->$id;
    } 
    
    public function setCommande($commande){
        $this->commande=$commande;
    }
    
    public function setId($id){
        $this->id=$id;
    }
}