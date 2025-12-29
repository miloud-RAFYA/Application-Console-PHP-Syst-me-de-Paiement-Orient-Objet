<?php
require_once __DIR__ . '/../entity/paiement.php';
require_once __DIR__ . '/../entity/carteBancaire.php';
require_once __DIR__ . '/../entity/paypal.php';
require_once __DIR__ . '/../entity/virement.php';
require_once __DIR__ . '/../config/databaseConnection.php';
require_once __DIR__ . '/../exception/ValidationException.php';



class PaiementRepository
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public $query;

    public function querypaiement($query, $param = [])
    {
        if (empty($param)) {
            $this->query = $this->conn->prepare($query);
            $this->query->execute();
            return $this->query->fetchAll(PDO::FETCH_OBJ);

        } else {
            $this->query = $this->conn->prepare($query);
            $this->query->execute($param);
            return $this->query->fetchAll(PDO::FETCH_OBJ);
        }
    }
    public function fetchPaiement()
    {
        return $this->querypaiement('select * from paiements ps join paypal_accounts pa on ps.id=pa.payment_id');
    }
    public function checkId($id)
    {
        try {
            $sql = "select * from commandes where id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $obj = $stmt->fetch(PDO::FETCH_OBJ);

            $clientrep = new CommendeRepository();
            $client = $clientrep->checkId($obj->user_id);
            $commande = new commande($obj->montant_total, $obj->statut);
            $commande->setClient($client);
            $commande->setId($obj->id);
            return $commande;
        } catch (PDOException $e) {
            throw new ValidationException("Error in serch id", 404, $e);
        }
    }
    public function countRows(): int
    {
        return $this->query->rowcount();
    }

    public function create($paiement)
    {
        try {

            $montant = $paiement->getMontant();
            $statut = $paiement->getStatut();
            $commande = $paiement->getCommande();
            $commande_id = $commande ? $commande->id : null;


            $sql = "INSERT INTO paiements (montant, statut, commande_id) 
                VALUES (:montant, :statut, :commande_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':montant', $montant);
            $stmt->bindParam(':statut', $statut);
            $stmt->bindParam(':commande_id', $commande_id);
            $stmt->execute();


            $payment_id = $this->conn->lastInsertId();


            if ($paiement instanceof Virement) {
                $iban = $paiement->getIban();
                $bank_name = $paiement->getBankName();

                $query = "INSERT INTO bank_transfers (payment_id, iban, bank_name) 
                      VALUES (:payment_id, :iban, :bank_name)";
                $stmtv = $this->conn->prepare($query);
                $stmtv->bindParam(':payment_id', $payment_id, PDO::PARAM_INT);
                $stmtv->bindParam(':iban', $iban);
                $stmtv->bindParam(':bank_name', $bank_name);
                $stmtv->execute();

                echo "Virement enregistre avec succes. ID: $payment_id\n";
            } else if ($paiement instanceof CarteBancaire) {
                $card_number_last4 = $paiement->card_number_last4;
                $card_type = $paiement->card_type;
                $card_holder = $paiement->card_holder;

                $query = "INSERT INTO bank_cards (payment_id, card_number_last4, card_holder ,card_type) 
                      VALUES (:payment_id, :card_number_last4, :card_holder,:card_type)";
                $stmtv = $this->conn->prepare($query);
                $stmtv->bindParam(':payment_id', $payment_id, PDO::PARAM_INT);
                $stmtv->bindParam(':card_number_last4', $card_number_last4);
                $stmtv->bindParam(':card_holder', $card_holder);
                $stmtv->bindParam(':card_type', $card_type);
                $stmtv->execute();

                echo "CarteBancaire enregistre avec succes. ID: $payment_id\n";
            } else {
                 $paypal_email = $paiement->paypal_email;
                $account_type = $paiement->account_type;

                $query = "INSERT INTO bank_cards (payment_id, paypal_email, account_type) 
                      VALUES (:payment_id, :paypal_email, :account_type)";
                $stmtv = $this->conn->prepare($query);
                $stmtv->bindParam(':payment_id', $payment_id, PDO::PARAM_INT);
                $stmtv->bindParam(':paypal_email', $paypal_email);
                $stmtv->bindParam(':account_type', $account_type);
                $stmtv->execute();

                echo "Paypal enregistre avec succes. ID: $payment_id\n";
            }

            return $payment_id;

        } catch (PDOException $e) {
            throw new ValidationException('Erreur lors de la creation du paiement: ' . $e->getMessage(), 147, $e);
        }
    }
    public function fetchAll($stmt)
    {
        $users = $stmt->fetchAll(PDO::FETCH_OBJ) ?: [];
        return $users;
    }

    public function update(commande $commande)
    {
    }
}




?>