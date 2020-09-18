<?php


namespace App;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;

class DBConnection
{
    public function getEntityManager()
    {
        // Create a simple "default" Doctrine ORM configuration for Annotations
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/App"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

        // database configuration parameters
        $conn = array(
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASWORD'],
            'host' => $_ENV['DB_HOST_NAME'],
            'driver' => 'pdo_mysql',
        );

        try {
            return EntityManager::create($conn, $config);
        } catch (ORMException $e) {
            throw new \Exception('ERROR: Cannot create EntityManager: '.$e->getMessage());
        }
    }

}