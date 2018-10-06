<?php

require_once "DB.php";

Class Reply {
	private $db = null;

	public function __construct($db) {
    	$this->db = $db;
	}


}
