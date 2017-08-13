<?php session_start(); 
if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] ==true)) {
	header("Location: gra.php");
	exit();
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<title>formularz logowania</title>
</head>
<body>
<h1>tylko martwi ujrzeli  wojne</h1><br><br>
<a href="rejestracja.php"> rejestracja - zaloz darmowe konto</a><br><br>
<form action="zaloguj.php" method="post">
	login : <input type="text" name="login"><br><br><br>

	haslo : <input type="password" name="haslo"><br><br><br>
	<input type="submit" value="zaloguj"><br><br>
</form>
<?php 
if(isset($_SESSION['blad'])){
	echo "<br>".$_SESSION['blad'];
}


 ?>
</body>
</html>
