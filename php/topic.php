<?php
  session_start();

  require_once '../vendor/autoload.php';
  require_once '../classes/DB.php';
  require_once '../classes/User.php';
  require_once '../classes/Category.php';
  require_once '../classes/Topic.php';
  require_once '../classes/Reply.php';

  $loader = new Twig_Loader_Filesystem('../html');
  $twig = new Twig_Environment($loader, array(
    //'cache' => './compilation_cache';
    // Can add cache after finished development for faster loading times
  ));
  $data = [];
  $data['id'] = htmlspecialchars($_GET["id"]);
  $db = DB::getDBConnection();
  $user = new User($db);
  $category = new Category($db);
  $topic = new Topic($db);
  $reply = new Reply($db);

  if ($user->isLoggedIn()) {
    $data['loggedIn'] = "true";
  }
  $data['categories'] = $category->getCategories();
  $data['topic'] = $topic->getTopicById($data['id']);
  $data['replies'] = $reply->getRepliesForTopic($data['id']);
  echo $twig->render('topic.html', $data);
