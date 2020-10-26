<?php

include 'database.php';
include 'helper.php';

// initialize the session
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
	header('location: index.php');
	exit;
}

$db = new database('localhost', 'root', '', 'project1', 'utf8');
$helper = new Helper();

// form would initially be used to add user. therefore, update should default to false.
$update_user = false;

// we get redirected to add_new_user.php when admin clicks 'edit' in the table
// to this page, we pass a value, which we retrieve the user_id from
if(isset($_GET['usertype_id']) && isset($_GET['persoon_id'])){

	$update_user = true;

	$usertype_id = $_GET['usertype_id'];
	$account_info = $db->getAccountInformation($_GET['usertype_id']);

	// account information
	$username = $account_info['username'];
	$email = $account_info['email'];
   
	$persoon_id = $_GET['persoon_id'];
	$persoon_info = $db->getPersoonInformation($persoon_id);

	// person information
	$voornaam = $persoon_info['voornaam'];
	$tussenvoegsel = $persoon_info['tussenvoegsel'];
	$achternaam = $persoon_info['achternaam'];
}
// checks if posted form is a new entry or update of existing entry
$nameAttr = 'submit';

if(isset($_POST['update'])){
	$nameAttr = 'update';
}

if(isset($_POST[$nameAttr])){
	// array with values of the name attribute of the form (required fields)
	$fields = array(
		'type_id', 'username', 'email', 'password', 'voornaam', 'achternaam'
	);
   
	$fields_validated = $helper->field_validation($fields);

	if($fields_validated){
		// account
		$type_id = $_POST['type_id'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];

		// person
		$voornaam = $_POST['voornaam'];
		$tussenvoegsel = isset($_POST['tussenvoegsel']) ? trim(strtolower($_POST['tussenvoegsel'])) : NULL; //nullable
		$achternaam = trim(strtolower($_POST['achternaam']));

		if($nameAttr == 'submit'){
			echo 'in submit';
			$msg = $db->addAccount($voornaam, $db::GEBRUIKER, $tussenvoegsel, $achternaam, $email, $username, $password);
			echo 'after msg';
		}else{
			echo 'in update';
			$account = [
				'account_id'=>$_POST['user_id'],
				'type_id'=>$_POST['type_id'], 
				'username'=>$_POST['username'], 
				'email'=>$_POST['email']
			];

			$persoon = [
				'persoon_id'=>$_POST['persoon_id'],
				'voornaam'=>$_POST['voornaam'], 
				'tussenvoegsel'=>$_POST['tussenvoegsel'], 
				'achternaam'=>$_POST['achternaam']
			];

			$update_msg = $db->updateUser($account, $persoon);
			sleep(3);
			header('location: view_edit_delete.php');
			exit;
		}
	}else{
		$missingFieldError = "Input for one of more fields missing. Please provide all required values and try again.";
	}
}
?>

<html>
	<head>
		<title>Welcome!</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div>
			<a class="active" href="welcome_admin.php">Home</a>
			<a href="add_new_user.php">Add user</a>
			<a href="view_edit_delete.php">View, edit and/or delete user</a>
			<a href="logout.php">Logout</a>
		</div>
		<form action="add_new_user.php" method="POST">
			<input type="hidden" name="usertype_id" value="<?php echo isset($_GET['usertype_id']) ? $_GET['users_id'] : ''; ?>">
			<input type="hidden" name="persoon_id" value="<?php echo isset($_GET['persoon_id']) ? $_GET['persoon_id'] : ''; ?>">
			
			<h1> Account details </h1>
			<select name='type_id' id='type_id'>
				<option value=1>Admin</option>
				<option value=2>User</option>
			</select><br>
			<input type="text" id="username" name="username" placeholder="Gebruikersnaam" value="<?php if(isset($_POST["username"])){ echo htmlentities($_POST["username"]);}elseif($update_user){echo $username;}else{echo '';}; ?>" required /><br>
			<input type="email" id="email" name="email" placeholder="Email" value="<?php if(isset($_POST["email"])){ echo htmlentities($_POST["email"]);}elseif($update_user){echo $email;}else{echo '';}; ?>" required /><br>
			<input type="password" id="password" name="password" placeholder="Password" value='helloworld' <?php if($update_user){?> hidden <?php } ?> required /><br>

			<h1> Person details </h1>
			<input type="text" id="voornaam" name="voornaam" placeholder="Voornaam" value="<?php if(isset($_POST["voornaam"])){ echo htmlentities($_POST["voornaam"]);}elseif($update_user){echo $voornaam;}else{echo '';}; ?>" required /><br>
			<input type="text" id="tussenvoegsel" name="tussenvoegsel" placeholder="Tussenvoegsel" value="<?php if(isset($_POST["tussenvoegsel"])){ echo htmlentities($_POST["tussenvoegsel"]);}elseif($tussenvoegsel){echo $tussenvoegsel;}else{echo '';}; ?>"/><br>
			<input type="text" id="achternaam" name="achternaam" placeholder="Achternaam" value="<?php if(isset($_POST["achternaam"])){ echo htmlentities($_POST["achternaam"]);}elseif($update_user){echo $achternaam;}else{echo '';}; ?>" required /><br>
			
			<span class='succes'><?php echo ((isset($update_msg) && $update_msg != '') ? htmlentities($update_msg) ." <br>" : '')?></span>
			<span class='succes'><?php echo ((isset($msg) && $msg != '') ? htmlentities($msg) ." <br>" : '')?></span>
			<input type="submit" name="<?php if($update_user){echo 'update';}else{echo 'submit';}?>" value="<?php if($update_user){echo 'Update';}else{echo 'Add user';}?>" />
		</form>
		
	</body>
</html>