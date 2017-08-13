<?php 
session_start();
//sprawdza czy ustanowione login i haslo
require_once "database.php";

if((!isset($_POST['login'])) || (!isset($_POST['haslo']))){
	header("Location:index.php");
	exit();
}

require_once 'database.php';


	$login = $_POST['login'];
	$haslo = $_POST['haslo'];

	$login = htmlentities($login,ENT_QUOTES, "UTF-8");
	// $haslo = htmlentities($haslo,ENT_QUOTES, "UTF-8");


// $sql ="SELECT * FROM uzytkownicy WHERE user ='$login' AND pass='$haslo'";

$query = sprintf("SELECT * FROM uzytkownicy WHERE user ='%s'",
	mysqli_real_escape_string($con,$login)
	
	);
//w pierwszym %s wstawi pierwszy argument po przecinku
///w drugim %s kolejny i dalej analogicznie
if($rezultat = $con->query($query)){
	$user = $rezultat->num_rows;

	if($user >0){
		$row= $rezultat->fetch_assoc(); 
		echo $haslo;
		if(password_verify($haslo,$row['pass'])){
			$_SESSION['zalogowany'] = true;
			
			$_SESSION['id']= $row['id'];
			$_SESSION['user'] = $row['user'];
			$_SESSION['drewno'] = $row['drewno'];
			$_SESSION['kamien'] = $row['kamien'];
			$_SESSION['zboze'] = $row['zboze'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['dnipremium'] = $row['dnipremium'];

			unset($_SESSION['blad']);
					
			$rezultat->free();
			header('Location:gra.php');
		}else{

			$_SESSION['blad']='<span style="color:red">zly login</span>';
			header("Location:index.php");

		}



	}else{

		$_SESSION['blad']='<span style="color:red">\nieprawidlowa login badz haslo</span>';
		header("Location:index.php");

	}


}



$con->close();




 ?>