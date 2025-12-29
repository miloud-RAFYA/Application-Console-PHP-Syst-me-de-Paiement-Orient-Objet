<?php
abstract class Paiement {
    protected $id;
    protected $date_paiement;
    protected $statut; 
    protected $montant; 
    protected $commande; 

    public function __construct($statut, $montant){
        $this->statut = $statut;
        $this->montant = $montant;
        $this->date_paiement = date('Y-m-d H:i:s');
    }

   
    public function getId() {
        return $this->id;
    }
    
    public function getMontant() {
        return $this->montant;
    }
    
    public function getStatut() {
        return $this->statut;
    }
    
    public function getCommande() {
        return $this->commande;
    }
    
    public function setCommande($commande) {
        $this->commande = $commande;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
   
  
}
?>