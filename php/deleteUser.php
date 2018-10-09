<?php
session_start();

require_once '../classes/DB.php';
require_once '../classes/User.php';

$db = DB::getDBConnection();
$user = new User($db);
$data = [];
$user->deleteUser($_POST['delete']);

$headerloc = 'Location: adminPage.php';
header($headerloc);
