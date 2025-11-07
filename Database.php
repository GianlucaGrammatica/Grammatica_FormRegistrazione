<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/config');
$dotenv->load();
$dotenv->required(['DBUSER', 'DBNAME', 'DBHOST'])->notEmpty();

class Database
{

    private static $instance = null;

    private $pdo;

    private function __construct()
    {
        $this->pdo = new PDO("mysql:host=" . $_ENV["DBHOST"] . ";dbname=" . $_ENV["DBNAME"], $_ENV["DBUSER"], $_ENV["DBPASSWORD"],

            // Per recuperare l'array dei risultati in automatico
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }

    public static function getInstance()
    {
        // Dentro le funzioni statiche si usa self al posto di this
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        // Istanza della connessione
        return $this->pdo;
    }

}