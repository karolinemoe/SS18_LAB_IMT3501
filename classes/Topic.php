<?php

require_once "DB.php";

Class Topic {
	private $db = null;

	public function __construct($db) {
    	$this->db = $db;
	}

	public function newTopic($data) {
		try {
			$sql = "INSERT INTO `topics`(`topicName`, `description`, `timestamp`, `categoryId`, `userId`) VALUES (?,?,?,?,?)";

			$sth = $this->db->prepare($sql);
			$sth->execute(array($data['topicName'], $data['content'], $data['timestamp'], $data['categoryId'], $data['user']));

			$sql = "SELECT `topicId` FROM `topics` ORDER BY `timestamp` DESC LIMIT 1";
			$sth = $this->db->prepare($sql);
			$sth->execute();
			$res = $sth->fetchColumn();
			//$res['status'] = "OK";
			return $res;

		} catch(PDOException $e) {
			echo 'failed';
		}
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

	public function getTopicById($id) {
		try {
			$sql = 'SELECT t.topicId, t.topicName, t.description, t.timestamp, u.username
							FROM topics t
							INNER JOIN user u ON t.userId = u.userId
							WHERE t.topicId = ?';
			$sth = $this->db->prepare($sql);
			$sth->execute(array($id));
			$topic = $sth->fetch(PDO::FETCH_ASSOC);
			return $topic;
		}  catch(PDOException $e) {
      // NOTE DON'T USE THIS IN PRODUCTION
      // NOTE NEVER GIVE CRUCIAL INFORMATION TO USERS
      echo 'Connection failed: ' . $e->getMessage();
		}
	}

}
