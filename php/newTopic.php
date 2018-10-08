<?php 

require_once '../classes/DB.php';
require_once '../classes/Topic.php';

$db = DB::getDBConnection();
$topic = new Topic($db);

$data = [];

$data['topicName'] = $_POST['name'];
$data['content'] = $_POST['content'];
$data['category'] = $_POST['category'];
$t=time();
$data['timestamp'] = (date("Y-m-d h-i-s",$t));

echo $data['topicName'], "   ", $data['content'], "   ", $data['category'], "    ", $data['timestamp'];

$res = [];
$res = $topic->newTopic($data);
echo $res['id'];
$id = (int) $res['id'];
$headerloc = 'Location: topic.php?id=' + $id;
echo $headerloc;

header($headerloc);
