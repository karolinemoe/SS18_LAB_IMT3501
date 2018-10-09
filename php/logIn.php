z<?php
  session_start();

  require_once '../vendor/autoload.php';
  require_once '../classes/DB.php';
  require_once '../classes/User.php';
  require_once '../classes/LogDB.php';

  $loader = new Twig_Loader_Filesystem('../html');
  $twig = new Twig_Environment($loader, array(
    //'cache' => './compilation_cache';
    // Can add cache after finished development for faster loading times
  ));

  $db = DB::getDBConnection();
  $logdb = LogDB::getDBConnection();
  $user = new User($db, $logdb);

  $data = [];
  if ($user->isLoggedIn()) {
    header('Location: index.php');
  }
  else if (!isset($_POST['username'])){
    echo $twig->render('index.html', array());
  }
  else {
    $data['username'] = $_POST['username'];
    $data['password'] = $_POST['password'];
    $data['timestamp'] = (date("Y-m-d H-i-s",$t));

    $res = $user->logIn($data);
    header('Location: index.php');
  }
