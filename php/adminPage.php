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
  $data = [];
  $db = DB::getDBConnection();
  $logdb = LogDB::getDBConnection();
  $user = new User($db, $logdb);

  if ($user->isLoggedIn()) {
    $data['loggedIn'] = "true";
  }

  if ($user->isAdmin()) {
    $data['isAdmin'] = 'true';
  }

  $data['users'] = $user->getUsers();

  echo $twig->render('adminPage.html', $data);
