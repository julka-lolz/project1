<?php

include 'database.php';

$db = new database('localhost', 'root', '', 'project1', 'utf8');
$fieldnames = array("voornaam", "achternaam", "e-mail", "gebruikersnaam", "wachtwoord", "herhaal wachtwoord"); 
$error = false;

foreach($fieldnames as $fieldname){
	if (isset($_POST[$fieldname])){
		$error = True;
	}
}

?>
<html>	
	<div>
		<form action="signup.php" method="POST">
			<label for="Voornaam"><b>Voornaam</b><br></label>
			<input type="text" placeholder="Vul in je voornaam" name="voornaam" required><br><br>
			<label for="Tussenvoegsel"><b>Tussenvoegsel</b><br></label>
			<input type="text" placeholder="Vul in je tussenvoegsel" name="tussenvoegsel"><br><br>
			<label for="Achternaam"><b>Achternaam</b><br></label>
			<input type="text" placeholder="Vul in je achternaam" name="achternaam" required><br><br>
			<label for="E-mail"><b>E-mail</b><br></label>
			<input type="email" placeholder="Vul in je e-mail" name="e-mail" required><br><br>
			<label for="Gebruikersnaam"><b>Gebruikersnaam</b><br></label>
			<input type="text" placeholder="Vul in je gebruikersnaam" name="gebruikersnaam" required><br><br>
			<label for="Wachtwoord"><b>Wachtwoord</b><br></label>
			<input type="password" placeholder="Vul in je wachtwoord" name="wachtwoord" required><br><br>
			<label for="Herhaal wachtwoord"><b>Herhaal wachtwoord</b><br></label>
			<input type="password" placeholder="Herhaal je wachtwoord" name="herhaaal wachtwoord" required><br><br>   
			<input type="submit">
	</div>
</html>