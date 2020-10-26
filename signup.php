<?php

include 'database.php';
include 'helper.php';

// ik check hier of mijn form gesubmit is
if(isset($_POST['submit'])){

	// array met de values van de name attribute van mijn reuiqred input fields
	$fieldnames = array(
		'voornaam', 'achternaam', 'email', 'username', 'password', 'repassword'
	); 

	$helper = new helper();
	$fields_validated = $helper->field_validation($fieldnames);

	if($fields_validated){

		// maak een instance van de database class en sla deze op in je db variable

		$db = new database('localhost', 'root', '', 'project1', 'utf8');

		$voornaam = $_POST["voornaam"];
		$tussenvoegsel = $_POST["tussenvoegsel"];
		$achternaam = $_POST["achternaam"];
		$email = $_POST["email"];
		$username = $_POST["username"];
		$password = $_POST["password"];
		$repassword = $_POST["repassword"];

		echo 'is signup'."<br>";

		$db->addAccount($voornaam, $db::GEBRUIKER, $tussenvoegsel, $achternaam, $email, $username, $password);
	}
	}
?>
<html>	
	<head>
		 <!-- include css file -->
		<link rel="stylesheet" href="style.css">
	</head>
		<div>
			<form action="signup.php" method="post">
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
				<input type="submit" name="submit">
		</div>
		<a href="index.php"> Terug naar inloggen</a><br>
</html>