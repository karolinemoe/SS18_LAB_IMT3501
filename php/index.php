<?php
  session_start();

  require_once '../vendor/autoload.php';
  require_once '../classes/DB.php';
  require_once '../classes/User.php';

  $loader = new Twig_Loader_Filesystem('../html');
  $twig = new Twig_Environment($loader, array(
    //'cache' => './compilation_cache';
    // Can add cache after finished development for faster loading times
  ));
  $data = [];
  $db = DB::getDBConnection();
  $user = new User($db);
  if ($user->isLoggedIn()) {
    $data['loggedIn'] = "true";
  }

  echo $twig->render('index.html', $data);
