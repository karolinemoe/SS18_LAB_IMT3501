<?php

require_once "DB.php";

class User {
  private $uid = -1;
  private $db = null;

  public function __construct($db) {
    $this->db = $db;
    if (isset($_POST['logOutForm'])) {
      unset($_SESSION['uid']);
    }
    else if (isset($_SESSION['uid'])) {
      $this->uid = $_SESSION['uid'];
    }
  }

  public function newUser($data) {
    try {
      $sql = 'INSERT INTO user(Username, Password, Email, Usertype) VALUES (?, ?, ?, ?)';
      $sth = $this->db->prepare($sql);
      $usertype = "normal";
      $password = password_hash($data['password'], PASSWORD_DEFAULT);
      $sth->execute(array($data['username'], $password, $data['email'], $usertype));
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
      $sql = 'SELECT UserId, Username, Password FROM User WHERE Username=?';
      $sth = $this->db->prepare($sql);
      $sth->execute(array($data['username']));
      $res = $sth->fetch(PDO::FETCH_ASSOC);
      if ($res['Username'] == $data['username']) {
        if (password_verify($res['Password'], $data['password'])) {
          $res['status'] = 'OK';
          $res['message'] = 'Logged in';
          $this->uid = $res['UserId'];
        }
        else {
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
  }

  public function isLoggedIn() {
    return $this->uid != -1;
  }
}
