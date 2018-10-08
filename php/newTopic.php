<?php
session_start();

require_once '../classes/DB.php';
require_once '../classes/Topic.php';

$db = DB::getDBConnection();
$topic = new Topic($db);

$data = [];

$data['topicName'] = $_POST['name'];
$data['content'] = $_POST['content'];
$data['category'] = $_POST['category'];
$data['user'] = $_SESSION['uid'];
$t=time();
$data['timestamp'] = (date("Y-m-d H-i-s",$t));

echo $data['topicName'], "   ", $data['content'], "   ", $data['category'], "    ", $data['timestamp'];

$res = $topic->newTopic($data);
//echo $res['id'];
//$id = (int) $res['id'];
$headerloc = 'Location: topic.php?id=' . $res;
header($headerloc);
