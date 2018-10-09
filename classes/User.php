<?php

require_once "DB.php";
require_once "LogDB.php";

class User {
  private $uid = -1;
  private $db = null;
  private $logdb = null;

  public function __construct($db, $logdb) {
    $this->db = $db;
    $this->logdb = $logdb;
    if (isset($_POST['logOutForm'])) {
      unset($_SESSION['uid']);
      // Avoid Session Fixation by changing session id on logout
      session_regenerate_id();
    }
    else if (isset($_SESSION['uid'])) {
      $this->uid = $_SESSION['uid'];
    }

  }

  public function newUser($data) {
    try {
      $sql = 'SELECT COUNT(userId) FROM user WHERE username = ?';
      $sth = $this->db->prepare($sql);
      $sth->execute(array($data['username']));
      if ($sth->rowCount()==0) {
        $sql = 'INSERT INTO user(username, password, email, usertype) VALUES (?, ?, ?, ?)';
          $sth = $this->db->prepare($sql);
          $usertype = "normal";
          $password = password_hash($data['password'], PASSWORD_DEFAULT);
          $sth->execute(array($data['username'], $password, $data['email'], $usertype));
      } else { 
          $res['taken'] = "This username is allready taken";
      }
    }
    catch(PDOException $e) {
      // NOTE DON'T USE THIS IN PRODUCTION
      // NOTE NEVER GIVE CRUCIAL INFORMATION TO USERS
      echo 'Connection failed: ' . $e->getMessage();
    }
    $result = [];
    if ($sth->rowCount()==1) {
      $res['status'] = 'OK';
      $res['message'] = 'User was added';

    }
    else {
      $res['status'] = 'ERROR';
      $res['message'] = 'User was not added';
    }
    return $res;
  }

  public function logIn($data) {
    $res = [];
    try {
      $sql = 'SELECT userId, username, password FROM user WHERE username=?';
      $sth = $this->db->prepare($sql);
      $sth->execute(array($data['username']));
      $resSql = $sth->fetch(PDO::FETCH_ASSOC);
      if ($resSql['username'] == $data['username']) {
        if (password_verify($data['password'], $resSql['password'])) {
          $res['status'] = 'OK';
          $res['message'] = 'Logged in';
          $this->uid = $resSql['userId'];
          // Avoid Session Fixation by changing session id on login
          session_regenerate_id();
          // NOTE THIS MUST BE CHANGED
          $_SESSION['uid'] = $this->uid;
        }
        else {
          // If error insert into logdb
          try {
            $sql = 'SELECT userId FROM user WHERE username =?';
            $sth = $this->db->prepare($sql);
            $sth->execute(array($data['username']));
            $res = [];
            $res = $sth->fetch(PDO::FETCH_ASSOC);

            $sql = 'INSERT INTO failedlogins(`userId`) VALUES (?)';
            $sth = $this->logdb->prepare($sql);
            $sth->execute(array($res['userId']));
          } catch(PDOExeption $e) {
              // .. do error on error? 
          }
          $res['status'] = 'ERROR';
          $res['message'] = 'Wrong username/password';
        }
      }
      else {
        $res['status'] = 'ERROR';
        $res['message'] = 'Wrong username/password';
      }
    }
    catch(PDOException $e) {
      // NOTE DON'T USE THIS IN PRODUCTION
      // NOTE NEVER GIVE CRUCIAL INFORMATION TO USERS
      echo 'Connection failed: ' . $e->getMessage();
    }
    return $res;
  }

  public function isLoggedIn() {
    return $this->uid != -1;
  }

  public function isAdmin() {
    try {
      $res = [];
      $sql = "SELECT usertype FROM user WHERE userId = ?";
      $sth = $this->db->prepare($sql);
      $sth->execute(array($this->uid));
      $res = $sth->fetchColumn();
    }
    catch(PDOException $e) {
      // NOTE DON'T USE THIS IN PRODUCTION
      // NOTE NEVER GIVE CRUCIAL INFORMATION TO USERS
      echo 'Connection failed: ' . $e->getMessage();
    }
    if ($res == "admin") return true;
    else return false;
  }

  public function getUser() {
    return $this->uid;
  }

  public function newPassword($data) {
    $current = $this->currentPass($data);
    if ($current == "Incorrect") {
      $res['status'] = "ERROR";
      $res['message'] = "Wrong current password";
    }
    else if ($this->checkOldPwords($data) == "Used") {

      $res['status'] = "ERROR";
      $res['message'] = "Password has already been used on this site. Please try again.";
    }
    else {
      try {
        $sql = 'INSERT INTO oldpwhash(userId, salt, pWHash) VALUES (?, ?, ?)';
        $sth = $this->db->prepare($sql);
        $salt = password_hash("Auto", PASSWORD_DEFAULT);
        $oldpword = password_hash($data['oldpword'], PASSWORD_DEFAULT);
        $sth->execute(array($data['userId'], $salt, $oldpword));
      }
      catch(PDOException $e) {
        // NOTE DON'T USE THIS IN PRODUCTION
        // NOTE NEVER GIVE CRUCIAL INFORMATION TO USERS
        echo 'Connection failed: ' . $e->getMessage();
      }
      $result = [];
      if ($sth->rowCount()==1) {
        try {
          $sql = 'UPDATE user SET password=? WHERE userId=?';
          $sth = $this->db->prepare($sql);
          $password = password_hash($data['newpword'], PASSWORD_DEFAULT);
          $sth->execute(array($password, $data['userId']));
        }
        catch(PDOException $e) {
          // NOTE DON'T USE THIS IN PRODUCTION
          // NOTE NEVER GIVE CRUCIAL INFORMATION TO USERS
          echo 'Connection failed: ' . $e->getMessage();
        }
        if ($sth->rowCount()==1) {
          $res['status'] = 'OK';
          $res['message'] = 'Password was changed';
        }
        else {
          $res['status'] = 'ERROR';
          $res['message'] = 'Password was not changed';
        }
      }
      else {
        $res['status'] = 'ERROR';
        $res['message'] = 'Password was not changed';
      }
    }
    return $res;
  }

  public function checkOldPwords($data) {
    try {
      $sql = 'SELECT * FROM oldpwhash WHERE userId=?';
      $sth = $this->db->prepare($sql);
      $sth->execute(array($data['userId']));
      $used = "Used";
      $notUsed = "NotUsed";
      $pwords = [];
      while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $pwords[] = $row;
        if (password_verify($data['newpword'], $row['pWHash'])) {
          return $used;
        }
      }
      return $notUsed;
    }
    catch(PDOException $e) {
      // NOTE DON'T USE THIS IN PRODUCTION
      // NOTE NEVER GIVE CRUCIAL INFORMATION TO USERS
      echo 'Connection failed: ' . $e->getMessage();
    }
  }

  public function currentPass($data) {
    try {
      $sql = 'SELECT userId, password FROM user WHERE userId=?';
      $sth = $this->db->prepare($sql);
      $sth->execute(array($data['userId']));
      $resSql = $sth->fetch(PDO::FETCH_ASSOC);
      $used = "Correct";
      $notUsed = "Incorrect";
      if (password_verify($data['oldpword'], $resSql['password'])) {
        return $used;
      }
      else {
        return $notUsed;
      }
    }
    catch(PDOException $e) {
      // NOTE DON'T USE THIS IN PRODUCTION
      // NOTE NEVER GIVE CRUCIAL INFORMATION TO USERS
      echo 'Connection failed: ' . $e->getMessage();
    }
  }

  public function getUsers() {
    $res = [];
    try {
      $sql = 'SELECT userId, username, email, usertype
							FROM user
              WHERE usertype != "banned"
							ORDER BY usertype ASC';
			$sth = $this->db->prepare($sql);
			$sth->execute(array());
			$replies = [];
			while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
				$res[] = $row;
			}
			return $res;
    } catch(PDOException $e) {
      // NOTE DON'T USE THIS IN PRODUCTION
      // NOTE NEVER GIVE CRUCIAL INFORMATION TO USERS
      echo 'Connection failed: ' . $e->getMessage();
		}
  }

  public function deleteUser($id) {
    $sql = 'UPDATE user SET usertype = "banned", username ="banned" WHERE userId=?';
    $sth = $this->db->prepare($sql);
    $sth->execute(array($id));
  }
}
