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

    public function queryClient($query, $param = [])
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
    public function fetchClient(){
        return $this->queryClient('select *from users');
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




?>