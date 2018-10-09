<?php

class LogDB {
  private static $db=null;
  private $dsn = 'mysql:dbname=logdb;port=3306;host=127.0.0.1';
  // NOTE SHOULD ADD A USERNAME AND A PASSWORD TO THE DB
  private $user = 'root';
  private $password = '';
  private $dbh = null;

  private function __construct() {
    try {
        $this->dbh = new PDO($this->dsn, $this->user, $this->password);
    } catch (PDOException $e) {
        // NOTE DON'T USE THIS IN PRODUCTION
        // NOTE NEVER GIVE CRUCIAL INFORMATION TO USERS
        echo 'Connection failed: ' . $e->getMessage();
    }
  }

  public static function getDBConnection() {
      if (LogDB::$db==null) {
        LogDB::$db = new self();
      }
      return LogDB::$db->dbh;
  }
}