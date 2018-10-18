<?php
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
$data = [];
$db = DB::getDBConnection();
$logdb = LogDB::getDBConnection();

$user = new User($db, $logdb);

if (!$user->isLoggedIn()) {
  header('Location: index.php');
}

else if (isset($_POST['oldpword'])) {
  $data['userId'] = $user->getUser();
  $data['oldpword'] = $_POST['oldpword'];
  $data['newpword'] = $_POST['newpword'];
  $data = $user->newPassword($data);
}

$data['loggedIn'] = "true";
echo $twig->render('profile.html', $data);
