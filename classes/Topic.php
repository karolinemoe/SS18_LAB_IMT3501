<?php

require_once "DB.php";

Class Topic {
	private $db = null;

	public function __construct($db) {
    	$this->db = $db;
	}

	public function getTopics() {
		try {
			$sql = 'SELECT * FROM topics';
			$sth = $this->db->prepare($sql);
			$sth->execute();
			$topics = [];
			while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
				$topics[] = $row;
			}
			return $topics;
		}  catch(PDOException $e) {
      // NOTE DON'T USE THIS IN PRODUCTION
      // NOTE NEVER GIVE CRUCIAL INFORMATION TO USERS
      echo 'Connection failed: ' . $e->getMessage();
		}
	}
}
