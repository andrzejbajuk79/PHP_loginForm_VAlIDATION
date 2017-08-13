
<?php
 session_start();
// jezeli nie jest ustawiona
if(!isset($_SESSION['zalogowany'])){
	header("Location: index.php");
	exit();
}

  ?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
	<title>hhh</title>
</head>
<body>
<?php 
echo 'witaj '.$_SESSION['user'].'<a href="logout.php">   wyloguj</a>'; 
echo "<p><b>drewno</b>: ".$_SESSION['drewno'];
echo "| <b>kamien</b>: ".$_SESSION['kamien'];
echo "| <b>zboze</b>".$_SESSION['zboze']."</p>";

echo "<b>email</b>: ".$_SESSION['email'];
echo "<br><b>dni premium </b>: ".$_SESSION['dnipremium'];

?>

</body>
</html>

