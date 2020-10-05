<?php

include 'database.php';



$fieldnames = array(
	'voornaam', 'achternaam', 'email', 'username', 'password', 'repassword'
	
); 

$error = False;

foreach($fieldnames as $fieldname){
	if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])){ 
		$error = True;
	}
	echo "$error <br>";
}

if(!$error){
	$db = new database('localhost', 'root', '', 'project1', 'utf8');

	$voornaam = $_POST["voornaam"];
	$tussenvoegsel = $_POST["tussenvoegsel"];
	$achternaam = $_POST["achternaam"];
	$email = $_POST["email"];
	$username = $_POST["username"];
	$password = $_POST["password"];
	$repassword = $_POST["repassword"];

	// pass + repass check

	$db->addAccount($voornaam, $tussenvoegsel, $achternaam, $email, $username, $password);
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
			<input type="password" placeholder="Herhaal je wachtwoord" name="repassword" required><br><br>   
			<input type="submit">
	</div>
</html>