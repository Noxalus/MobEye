<?php
try 
{
	$db = new PDO('mysql:host=localhost;dbname=mobeyes', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e) 
{
	echo $e;
}