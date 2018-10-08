<?php 

require_once '../classes/DB.php';
require_once '../classes/Topic.php';

$db = DB::getDBConnection();
$topic = new Topic($db);

$data = [];

$data['topicName'] = $_POST['name'];
$data['content'] = $_POST['content'];
$data['category'] = $_POST['category'];

$topic->newTopic($data);

