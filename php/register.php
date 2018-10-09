<?php
  session_start();

  require_once '../vendor/autoload.php';
  require_once '../classes/DB.php';
  require_once '../classes/LogDB.php';
  require_once '../classes/User.php';

  $loader = new Twig_Loader_Filesystem('../html');
  $twig = new Twig_Environment($loader, array(
    //'cache' => './compilation_cache';
    // Can add cache after finished development for faster loading times
  ));

  $db = DB::getDBConnection();
  $logdb = LogDB::getDBConnection();
  $user = new User($db, $logdb);

  $data = [];

  if(empty($_POST['agree']) || $_POST['agree'] != 'agree')

  if ($user->isLoggedIn()) {
    header('Location: index.php');
  }
  else if (!isset($_POST['username'])){
    echo $twig->render('register.html', array());
  }
  else {
    $data['username'] = $_POST['username'];
    $data['password'] = $_POST['password'];
    $data['email'] = $_POST['email'];

    $res = $user->newUser($data);
    echo $res['taken'];
    // Email validation
    if ($res['status'] == 'OK' && filter_var($data['email'], FILTER_VALIDATE_EMAIL)  ) header('Location: index.php');
    else echo $twig->render('register.html', array($res));
  }
