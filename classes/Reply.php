<?php

require_once "DB.php";

Class Reply {
	private $db = null;

	public function __construct($db) {
    	$this->db = $db;
	}

  public function getRepliesForTopic($id) {
    $replies = [];
    try {
      $sql = 'SELECT r.content, r.timestamp, u.username
							FROM replies r
							INNER JOIN user u ON r.userId = u.userId
							WHERE r.threadId = ?';
			$sth = $this->db->prepare($sql);
			$sth->execute(array($id));
			$replies = [];
			while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
				$replies[] = $row;
			}
			return $replies;
    } catch(PDOException $e) {
      // NOTE DON'T USE THIS IN PRODUCTION
      // NOTE NEVER GIVE CRUCIAL INFORMATION TO USERS
      echo 'Connection failed: ' . $e->getMessage();
		}
  }
}
