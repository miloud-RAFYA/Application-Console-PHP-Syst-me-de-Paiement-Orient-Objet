<?php
require_once __DIR__ . '/../entity/commande.php';
require_once __DIR__ . '/../entity/client.php';
require_once __DIR__ . '/../config/databaseConnection.php';
require_once __DIR__ . '/../exception/ValidationException.php';



class CommendeRepository
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public $query;

    public function queryCommande($query, $param = [])
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
    public function fetchCommande(){
         return $this->queryCommande('select * from commandes');
    }
    public function checkId($id){
    try{
     $sql ="select * from users where id = :id";
     $stmt = $this->conn->prepare($sql);
     $stmt->bindParam(':id',$id);
     $stmt->execute();
     $obj=$stmt->fetch(PDO::FETCH_OBJ);
     $client=new client($obj->name,$obj->email);
     $client->setClientId($obj->id);
     return $client ;
    }catch(PDOException $e){
            throw new ValidationException("Error in serch id",404,$e);
    }
    }
    public function countRows(): int
    {
        return $this->query->rowcount();
    }

    public function insert(commande $commande)
    {
        $montant_total = $commande->montant_total;
        $statut = $commande->statut;
        $client = $commande->client->id;
        $sql = "INSERT INTO commandes (montant_total,statut,user_id) VALUES (:montant_total,:statut,:user_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':montant_total', $montant_total);
        $stmt->bindParam(':statut', $statut);
        $stmt->bindParam(':user_id', $client);
        return $stmt->execute();
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