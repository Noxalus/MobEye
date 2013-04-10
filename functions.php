<?php

function get_missions()
{
	require_once('db.php');
	
	$result = array();
	$query = $db->query('SELECT * FROM missions');
	
	$result = $query->fetchAll();
	
	return $result;
}