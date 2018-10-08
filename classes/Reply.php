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
							WHERE r.topicId = ?';
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

	public function newReply($data) {
		try {
      $sql = 'INSERT INTO `replies`(`content`, `userId`, `topicId`, `subReplyOf`) VALUES(?, ?, ?, ?)';
			$sth = $this->db->prepare($sql);
			$data['subReplyOf'] = NULL;
			$sth->execute(array($data['content'], $data['userId'], $data['topicId'], $data['subReplyOf']));
    } catch(PDOException $e) {
      // NOTE DON'T USE THIS IN PRODUCTION
      // NOTE NEVER GIVE CRUCIAL INFORMATION TO USERS
      echo 'Connection failed: ' . $e->getMessage();
		}
		if ($sth->rowCount()==1) {
      $res['status'] = 'OK';
      $res['message'] = 'New comment was added';

    }
    else {
      $res['status'] = 'ERROR';
      $res['message'] = 'New comment was not added';
    }
    return $res;
	}
}
