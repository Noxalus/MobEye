<?php

function GetMissions()
{
	require_once('db.php');
	
	$result = array();
	$query = $db->query('SELECT * FROM missions WHERE is_hidden = 0');
	
	$result = $query->fetchAll();
	
	return $result;
}

function fetchAll($table)
{
	require_once('db.php');
	
	$result = array();

	$query = $db->query('SELECT * FROM ' . $table);
	
	$result = $query->fetchAll();
	
	return $result;
}

function print_t($array)
{
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}