<?php

	require('api.php');

	$method_name = $_GET['method'];
	$method_json_args = $_GET['data'];
	
	$method_args = json_decode($method_json_args);
	
	switch ($method_name)
	{
		case 'login':

			print_t(login($method_json_args));
		
		break;
		
		case 'is_login':

			print_t(is_login($method_args['cookie']));
		
		break;

		case 'logout':

			print_t(logout($method_json_args));
		
		break;

		case 'new_user':

			print_t(new_user($method_json_args));
		
		break;

		case 'get_missions':
			
			print_t(get_missions());
		
		break;

		case 'get_user':
		
			print_t(get_user($method_args['cookie']));
		
		break;

		case 'accept_mission':

			print_t(accept_mission($method_args['cookie'], $method_args['mission_id']));
		
		break;

		case 'send_data':

			print_t(send_data($method_args['user_id'], $method_args['mission_id'], $method_args['mission_text'], $method_args['pictures']));
		
		break;
		
		case 'miss_mission':

			print_t(miss_mission($method_args['cookie'], $method_args['mission_id']));
		
		break;
	}
?>