<?php 
session_start();
if(!isset($_SESSION['udana_rejestracja'])){
	header("Location:index.php");
	exit();

}else{
	unset($_SESSION['udana_rejestracjaa']);
	}
	//usuwamy zmienn w razie niedanaje walidacji
	if(isset($_SESSION['fr_nick'])) unset($_SESSION['fr_nick']);
	if(isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
	if(isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
	if(isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
	if(isset($_SESSION['fr_regulamin'])) unset($_SESSION['fr_regulamin']);

	//usuwanie bledow rejestracjii
	if(isset($_SESSION['e_nick'])) unset($_SESSION['e_nick']);
	if(isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if(isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
	if(isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);
	if(isset($_SESSION['e_robot'])) unset($_SESSION['e_robot']);
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>witamy w php</title>
</head>
<body>
<h1>welcome</h1>
dziekujemy za rejestracje mozesz juz sie zalogowac na swoje konto <br><br><br>
<a href="index.php">zaloguj sie na swoje konto</a>
</body>
</html>