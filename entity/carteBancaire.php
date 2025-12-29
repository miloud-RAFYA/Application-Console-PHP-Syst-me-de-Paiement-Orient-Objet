<?php
class CarteBancaire extends Paiement {

    
    private $card_type; 
    private $card_holder; 
    private $card_number_last4; 


    public function __construct($statut,$montant, $card_type,$card_holder,$card_number_last4){
        parent :: __construct($statut,$montant);
        $this->card_type=$card_type;
        $this->card_holder=$card_holder;
        $this->card_number_last4=$card_number_last4;
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