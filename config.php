<?php 
	;session_start();

	define ('ROOT_PATH', realpath(dirname(__FILE__)));
	define('BASE_URL', 'http://localhost:8000/'); //portNumber

	$conn = mysqli_connect("localhost", "root", "Sahil@123", "billingSystem");

	if (!$conn) {
		error_log(mysqli_connect_error() . "\n", 3, ROOT_PATH.'/error.log');
	}

?>