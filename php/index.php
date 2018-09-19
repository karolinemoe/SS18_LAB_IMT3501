<?php
  require_once '../vendor/autoload.php';
  require_once '../classes/DB.php';
  require_once '../classes/User.php';

  $loader = new Twig_Loader_Filesystem('../html');
  $twig = new Twig_Environment($loader, array(
    //'cache' => './compilation_cache';
    // Can add cache after finished development for faster loading times
  ));

  $db = DB::getDBConnection();
  $user = new User($db);
  if ($user->isLoggedIn()) {
    $data['loggedIn'] = true;
  }
  else {
    $data['loggedIn'] = false;
  }


  $data = [];
  echo $twig->render('index.html', $data);
