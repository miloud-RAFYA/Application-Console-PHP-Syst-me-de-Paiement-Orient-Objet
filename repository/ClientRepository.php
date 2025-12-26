<?php
require_once __DIR__ . '/../entity/Client.php';
require_once __DIR__ . '/../config/databaseConnection.php';



class ClientRepository
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public $query;

    public function fetchClient($query, $param = [])
    {
        if (empty($param)) {
            $this->query = $this->conn->prepare($query);
            $this->query->execute();
            return $this->query->fetchAll(PDO::FETCH_ASSOC);

        } else {
            $this->query = $this->conn->prepare($query);
            $this->query->execute($param);
            return $this->query->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function countRows(): int
    {
        return $this->query->rowcount();
    }

    public function insert(client $client)
    {
        $name = $client->name;
        $email = $client->email;

        $sql = "INSERT INTO users (name , email) VALUES (:name,:email)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }
    public function fetchAll($stmt)
    {

        $users = $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];
        return $users;
    }

    public function update(client $client)
    {
    }
}



$clientRep = new ClientRepository();
$res = $clientRep->fetchClient('select *from users');
foreach ($res as $row) {
$client=new client( $row['name'],$row['email']);
echo $client;
};
?>