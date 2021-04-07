<?php

class Database
{
    private $host = DB_HOST;
    private $username = DB_USER;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;
    public $dbh;
    public $stmt;

    // Constructor
    public function __construct()
    {
        $this->dbh = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Query Function
    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    // Bind Function
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute Method
    public function execute()
    {
        return $this->stmt->execute();
    }

    // Get Last Insert Id Method
    public function getLastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    // Fetch Result Method
    public function fetchResult()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch All Results Method
    public function fetchResults()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
