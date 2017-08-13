<?php 

	$db_host = 'localhost';
	$db_name = 'osadnicy';
	$db_user = 'root';
	$db_pass = '';

	$con = @new mysqli($db_host,$db_user,$db_pass,$db_name);

// if($con->connect_errno!=0){
// 	echo 'Error '.$con->connect_errno.'Opis : '.$con->connect_error;
// }

 ?> 