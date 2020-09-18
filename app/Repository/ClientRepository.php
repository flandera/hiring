<?php


namespace App\Repository;


use App\DBConnection;
use Doctrine\ORM\EntityManager;

class ClientRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * ClientRepository constructor.
     */
    public function __construct()
    {
        $dbConnection = new DBConnection();
        $this->entityManager = $dbConnection->getEntityManager();
    }

    public function getClients()
    {
        $sql = "SELECT * FROM users";
        $conn = $this->entityManager->getConnection();
        $stmt = $conn->query($sql);
        $users = $stmt->fetchAll();
        if (!$users) {
            throw new \Exception('ERROR: Cannot find any users');
        }
        return $users;
    }
}