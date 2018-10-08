<?php
  session_start();

  require_once '../vendor/autoload.php';
  require_once '../classes/DB.php';
  require_once '../classes/User.php';
  require_once '../classes/Reply.php';

  $loader = new Twig_Loader_Filesystem('../html');
  $twig = new Twig_Environment($loader, array(
    //'cache' => './compilation_cache';
    // Can add cache after finished development for faster loading times
  ));

  $db = DB::getDBConnection();
  $user = new User($db);
  $reply = new Reply($db);

  $data = [];
  if (!isset($_POST['content'])){
    header('Location: index.php');
  }
  else {
    $data['userId'] = $_SESSION['uid'];
    $data['content'] = $_POST['content'];
    $data['topicId'] = $_POST['topicId'];
    $res = $reply->newReply($data);
    $headerloc = 'Location: topic.php?id=' . $data['topicId'];
    header($headerloc);
  }
