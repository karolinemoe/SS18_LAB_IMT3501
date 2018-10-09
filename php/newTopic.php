<?php
session_start();

require_once '../classes/DB.php';
require_once '../classes/Topic.php';

$db = DB::getDBConnection();
$topic = new Topic($db);

$data = [];

$data['topicName'] = $_POST['name'];
$data['content'] = $_POST['content'];
$data['categoryId'] = $_POST['categoryId'];
$data['user'] = $_SESSION['uid'];
$t=time();
$data['timestamp'] = (date("Y-m-d H-i-s",$t));

echo "Name:". $data['topicName']. "Content:". $data['content']. "ID:".$data['categoryId']. "Resten:". $data['timestamp'];

$res = $topic->newTopic($data);
//echo $res['id'];
//$id = (int) $res['id'];
$headerloc = 'Location: topic.php?id=' . $res;
header($headerloc);
