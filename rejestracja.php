<?php 
session_start();
	require_once('database.php');
if(isset($_POST['email'])){
	//udana walidacja
	$wszystko_ok = true;
	//nickanem
	$nick = $_POST['nick'];
	$email = $_POST['email'];
	$emailB = filter_var($email,FILTER_SANITIZE_EMAIL);
	$haslo1 = $_POST['haslo1'];
	$haslo2 =$_POST['haslo2'];


	//sprawdzeni dlugosci nicka
	if((strlen($nick)<4) || (strlen($nick)>20)){
		$wszystko_ok = false;
		$_SESSION['e_nick'] = 'nick musi posiadac od 3 do 20 znakow';
	}
	if(ctype_alnum($nick) == false){
		$wszystko_ok = false;
		$_SESSION['e_nick'] = 'niedozwolone znaki';
	}
	//adrs email
	if((filter_var($emailB,FILTER_VALIDATE_EMAIL)==false) || ($emailB !=$email)) {
		$wszystko_ok = false;
		$_SESSION['e_email'] = 'podaj poprawny adres email';
	}
	//poprawnos hasla
	if(strlen($haslo1)<4 || (strlen($haslo1)>20)){
		$wszystko_ok = false;
		$_SESSION['e_haslo'] = 'haslo musi posiadac od 8 do 20 znakow';


	}
	if($haslo1 != $haslo2) {
		$wszystko_ok = false;
		$_SESSION['e_haslo'] = 'podane hasla nie sa identyczne';
	}
	$haslo_hash = password_hash($haslo1,PASSWORD_DEFAULT);

	//regulamin
	if(!isset($_POST['regulamin'])){
		$wszystko_ok = false;
		$_SESSION['e_regulamin'] = 'potwierdz regulamin';
	}
	//bot or not, sprawdzanie recaptchy
	$secret = '6LfTsywUAAAAAOJjMgkZ9_LFn85ev-CSZ-iPtrto';
	$sprawdz =file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
	$odp = json_decode($sprawdz);


	if(!$odp->success){
		$wszystko_ok = false;
		$_SESSION['e_robot'] = 'jestes robotem';
	}
	//zapamietywanie danych zeby nie trzeb odswiezac
	
	$_SESSION['fr_nick'] =$nick;
	$_SESSION['fr_email'] = $email;
	$_SESSION['fr_haslo1'] =$haslo1;
	$_SESSION['fr_haslo2'] =$haslo2;
	if(isset($_POST['regulamin'])){
		$_SESSION['fr_regulamin'] = true;
	}


	mysqli_report(MYSQLI_REPORT_STRICT);
	try{

		$con = new mysqli($db_host,$db_user,$db_pass,$db_name);

		if($con->connect_errno!=0){
		throw new Exception(mysqli_connect_errno());
		
		}else{
			//czy email istniej
			$query="SELECT id FROM uzytkownicy WHERE email='$email'";
			$rezultat =$con->query($query);
			if(!$rezultat) throw new Exception($con->error);
			$ile_takich_maili = $rezultat->num_rows;
			if($ile_takich_maili>0){
				$wszystko_ok = false;
				$_SESSION['e_email'] = 'taki email juz istnieje!!';
			}
			//czy nick jest juz zarejestrowany
			$query="SELECT user FROM uzytkownicy WHERE user='$nick'";
			$rezultat =$con->query($query);
			if(!$rezultat) throw new Exception($con->error);
			$ile_takich_nick = $rezultat->num_rows;
			if($ile_takich_nick>0){
				$wszystko_ok = false;
				$_SESSION['e_nick'] = 'taki nick juz istnieje!!';
			}
			if($wszystko_ok == true) {
				$query ="INSERT INTO `uzytkownicy` (`id`, `user`, `pass`, `email`, `drewno`, `kamien`, `zboze`, `dnipremium`) VALUES (NULL, '$nick', '$haslo_hash', '$email', 100, 100, 100, 14)";
				if($con->query($query)){
					$_SESSION['udana_rejestracja']=true;
					header("Location:witamy.php");
				}else{
					throw new Exception($con->error);
				}
			}
			$con->close();
		}
	}catch(Exception $e){
		echo "<span style='color:red'>Blad servera.Prezpraszamy za niedogodnosci i zapraszamy w innym terminie!!</span>";
		echo "<br>Informacja Developerska: ".$e;
	}





	
} 


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<title>zaloz darmowe konto</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<style>
		.error {
			color:red;
			margin-top:10px;
			margin-bottom:10px;
		}
	</style>
</head>
<body>
<!-- bez action bo nie dokonujemy przekierowania do innego dokumentu -->
	<form method="post">
		Nickanme: <br> <input type="text" 
		value="<?php 
		if(isset($_SESSION['fr_nick'])){
			echo $_SESSION['fr_nick'] ;
			unset($_SESSION['fr_nick']);
		}
		
		?>" 
		name="nick"><br>
		<?php 
			if(isset($_SESSION['e_nick'])){
				echo "<div class='error'>".$_SESSION['e_nick']."</div>";
				unset($_SESSION['e_nick']);
			}
		 ?>
		Email: <br> <input type="text" 
		value="<?php 
				if(isset($_SESSION['fr_email'])){
			echo $_SESSION['fr_email'] ;
			unset($_SESSION['fr_email']);
		}
		 ?>" name="email"><br>
		<?php 
			if(isset($_SESSION['e_email'])){
				echo "<div class='error'>".$_SESSION['e_email']."</div>";
				unset($_SESSION['e_email']);
			}
		 ?>
		
		Password: <br> <input type="password" 
		value="<?php 
		if(isset($_SESSION['fr_haslo1'])){
			echo $_SESSION['fr_haslo1'] ;
			unset($_SESSION['fr_haslo1']);
		}
		?>" name="haslo1"><br>
		<?php 
			if(isset($_SESSION['e_haslo'])){
				echo "<div class='error'>".$_SESSION['e_haslo']."</div>";
				unset($_SESSION['e_haslo']);
			}
		 ?>
		Re-Password: <br> <input type="password" 
		value="<?php 
			if(isset($_SESSION['fr_haslo2'])){
			echo $_SESSION['fr_haslo2'] ;
			unset($_SESSION['fr_haslo2']);
		}
		 ?>" name="haslo2"><br>
		<label>
		<input type="checkbox" name='regulamin' 
		<?php  
			if(isset($_SESSION['fr_regulamin'])){
				echo "checked";
				unset($_SESSION['fr_regulamin']);
			}
		?>
		>Akcptuje  Regulamin</label><br><br>
		<div class="g-recaptcha" data-sitekey="6LfTsywUAAAAAEtQxYgMFCQRkh5VWx9Nrevu9tvv"></div><br>
		<?php 
			if(isset($_SESSION['e_regulamin'])){
				echo "<div class='error'>".$_SESSION['e_regulamin']."</div>";
				unset($_SESSION['e_regulamin']);
			}
		 ?>
		<input type="submit" value="Zarejestruj sie">
<?php 
			if(isset($_SESSION['e_robot'])){
				echo "<div class='error'>".$_SESSION['e_robot']."</div>";
				unset($_SESSION['e_robot']);
			}
		 ?>


	</form>
</body>
</html>
