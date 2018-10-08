<?php

require_once "DB.php";

Class Category {
	private $db = null;

	public function __construct($db) {
    	$this->db = $db;
	}

	public function getCategories() {
		try {
			$sql = 'SELECT * FROM category';
			$sth = $this->db->prepare($sql);
			$sth->execute();
			$categories = [];
			while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
				$categories[] = $row;
			}
			return $categories;
		}  catch(PDOException $e) {
      // NOTE DON'T USE THIS IN PRODUCTION
      // NOTE NEVER GIVE CRUCIAL INFORMATION TO USERS
      echo 'Connection failedXD: ' . $e->getMessage();
		}
	}
}
