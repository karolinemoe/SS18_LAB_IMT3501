<?php
session_start();

require_once '../classes/DB.php';
require_once '../classes/LogDB.php';
require_once '../classes/User.php';

$db = DB::getDBConnection();
$logdb = LogDB::getDBConnection();
$user = new User($db, $logdb);
$data = [];
if ($user->isAdmin())$user->deleteUser($_POST['delete']);

$headerloc = 'Location: adminPage.php';
header($headerloc);
