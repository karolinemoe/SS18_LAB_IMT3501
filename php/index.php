<?php
  require_once '../vendor/autoload.php';

  $loader = new Twig_Loader_Filesystem('../html');
  $twig = new Twig_Environment($loader, array(
    //'cache' => './compilation_cache';
    // Can add cache after finished development for faster loading times
  ));

  $data = [];
  echo $twig->render('index.html', $data);
?>
