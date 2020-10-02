<?php

include 'database.php';

$db = new database('localhost', 'root', '', 'project1', 'utf8');
$fieldnames = array(
	$_POST["voornaam"], 
	$_POST["achternaam"], 
	$_POST["email"], 
	$_POST["username"], 
	$_POST["password"]	
); 
$error = false;

foreach($fieldnames as $fieldname){
	if (isset($_POST[$fieldname])){
		$error = True;
	} else {
		if (!isset($_POST['submit'])) {
			$voornaam = $_POST["voornaam"];
			$tussenvoegsel = $_POST["tussenvoegsel"];
			$achternaam = $_POST["achternaam"];
			$email = $_POST["email"];
			$username = $_POST["username"];
			$password = $_POST["password"];
			$query=mysqli_query(
				"INSERT INTO 'account' AND 'persoon' (`voornaam`,`tussenvoegsel`,`achternaam`,`email`,`username`, 'password') 
				VALUES ('$voornaam','$tussenvoegsel','$achternaam','$email','$username', '$password')"
			);
			echo ('<br>Treść została dodana<br>');
		}
						
	}
}


?>
<html>	
	<div>
		<form action="signup.php" method="$_POST">
			<label for="Voornaam"><b>Voornaam</b><br></label>
			<input type="text" placeholder="Vul in je voornaam" name="voornaam" required><br><br>
			<label for="Tussenvoegsel"><b>Tussenvoegsel</b><br></label>
			<input type="text" placeholder="Vul in je tussenvoegsel" name="tussenvoegsel"><br><br>
			<label for="Achternaam"><b>Achternaam</b><br></label>
			<input type="text" placeholder="Vul in je achternaam" name="achternaam" required><br><br>
			<label for="E-mail"><b>E-mail</b><br></label>
			<input type="email" placeholder="Vul in je e-mail" name="email" required><br><br>
			<label for="Gebruikersnaam"><b>Gebruikersnaam</b><br></label>
			<input type="text" placeholder="Vul in je gebruikersnaam" name="username" required><br><br>
			<label for="Wachtwoord"><b>Wachtwoord</b><br></label>
			<input type="password" placeholder="Vul in je wachtwoord" name="password" required><br><br>
			<label for="Herhaal wachtwoord"><b>Herhaal wachtwoord</b><br></label>
			<input type="password" placeholder="Herhaal je wachtwoord" name="password" required><br><br>   
			<input type="submit">
	</div>
</html>