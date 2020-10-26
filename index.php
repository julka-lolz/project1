<?php

include 'database.php';
include 'helper.php';

// check the signup.php file for explanation on code
if(isset($_POST['submit'])){
	$fieldnames = array('username', 'password');

	$helper = new helper();
	$fields_validated = $helper->field_validation($fieldnames);
	echo '1234';
	echo '' + $fields_validated;
	if($fields_validated){
				
		$db = new database('localhost', 'root', '', 'project1', 'utf8');

		$username = $_POST['username'];
		$password = $_POST['password'];

		echo 'hallo'.'<br>';
		// user redirected to welcome page in case of succesful login.
		// unsuccessfull login results in an error message (string)
		$loginError = $db->login($username, $password);

	}
}
?>
<html>
	<head>
	<link rel="stylesheet" href="style.css">
	</head>
	<body>    
		<div>
			<h2>Inloggen </h2>
			<form action="index.php" method="post">
			<label for="Gebruikersnaam"><b>Gebruikersnaam</b><br></label>
			<input type="text" placeholder="Vul in je gebruikersnaam" name="username" required><br><br>
			<label for="Wachtwoord"><b>Wachtwoord</b><br></label>
			<input type="password" placeholder="Vul in je wachtwoord" name="password" required><br><br>            
			<span><?php echo ((isset($loginError) && $loginError != '') ? $loginError ."<br>" : '')?></span>
			<input type="submit" name="submit"><br><br>
			<a href="signup.php"> Geen accound? Click hier en maak een nieuwe aan.</a><br>
			<a href="lostpsw.php"> Wachtwoord of gebruikersnaam vergeten? Vraag hier om een nieuwe.</a>
		</div>
	</body>
</html>