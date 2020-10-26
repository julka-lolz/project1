<?php

class database{

	private $host;
	private $username;
	private $password;
	private $database;
	private $charset;
	private $db;

	 // create class constants (admin and user).
	const ADMIN = 1;
	const GEBRUIKER = 2;

	public function __construct($host,$username,$password,$database,$charset){

		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
		$this->charset = $charset;	

		try{
			// connectie with database			
			$dsn = "mysql:host=$this->host;dbname=$this->database;charset=$this->charset";
			$this->db = new PDO($dsn, $this->username, $this->password);
			$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			echo 'Succesfully connected'."<br>";
		}	// catch error
		catch (PDOexception $a){			
			$this->db->rollback();
			echo "Signup failed: ".$a->getMessage();
			throw $a;
			
		}
	}

	public function addAccount($voornaam, $type_id=self::GEBRUIKER, $tussenvoegsel, $achternaam, $email, $username, $password){
		//this functions inserts data from the form into the database.
		try{
			//transaction 			
			$this->db->beginTransaction();

			if(!$this->new_account($username)){
				return "Username already exists. Please pick another one, and try again.";
			}

			echo "begin transatie"."<br>";
			//add account	
			$sql1 = "INSERT INTO account(id, username, email, type_id, password, created_at, updated_at ) 
				VALUES(:id, :username, :email, :type_id, :password, :created_at, :updated_at)";
			echo "sql statement: ".$sql1."<br>";
			// prepare
			$stmt1 = $this->db->prepare($sql1);							
			//$type_id = 1;
			$hashPassword = password_hash($password, PASSWORD_DEFAULT);
			//execute
			$stmt1->execute(['id' => NULL, 'email'=>$email, 'type_id'=>$type_id, 'username'=>$username, 'password'=>$hashPassword, 'created_at'=>date("Y-m-d H:i:s"), 'updated_at'=>date("Y-m-d H:i:s")]);
			$account_id = $this->db->lastInsertId();
											
			//add persoon		
			$sql2 = "INSERT INTO persoon (id, account_id, voornaam, tussenvoegsel, achternaam, created_at, updated_at) 
				VALUES (:id, :account_id, :voornaam,:tussenvoegsel,:achternaam, :created_at, :updated_at)";
			echo "sql statement: ".$sql2."<br>";
			//prepare
			$stmt2 = $this->db->prepare($sql2);			
			//execute
			$stmt2->execute(['id' => NULL, 'account_id'=>$account_id, 'voornaam'=>$voornaam,'tussenvoegsel'=>$tussenvoegsel, 'achternaam'=>$achternaam, 'created_at'=>date("Y-m-d H:i:s"), 'updated_at'=>date("Y-m-d H:i:s")]);
			//commiten (dit hoeft maar een keer voor de hele transactie)
			$this->db->commit();
			echo "gelukt";
			
			// check if there's a session (created in login, should only visit here in case of admin login)
			if(isset($_SESSION) && $_SESSION['usertype'] == self::ADMIN){
				return "New user has been succesfully added to the database";
			}
		}
		catch (PDOexception $a){			
			$this->db->rollback();
			echo "Signup failed: ".$a->getMessage();
			throw $a;
			
		}
	}
	
	private function new_account($username){
		//this function checks if the account already exists.		
		$stmt = $this->db->prepare('SELECT * FROM account WHERE username=:username');
		$stmt->execute(['username'=>$username]);
		$result = $stmt->fetch();
		//the if loop checks if the account exists
		if(is_array($result) && count($result) > 0){
			return false;//does exists
		}

		return true;//does not exist
	}

	private function is_admin($username){
		//this function checks if the user is an admin.
		$sql = "SELECT type_id FROM account WHERE username = :username";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(['username'=>$username]);
		// result is an associative array (key-value pair)
		$result = $stmt->fetch();
		
		if($result['type_id'] == self::ADMIN){
			return true;//user is an admin
		}

		// user is not admin
		return false;
	}

	public function login($username, $password){
		// get id, usertype_id and password from account
		$sql = "
			SELECT 
				account.id as account_id, 
				persoon.id as person_id, 
				account.type_id, 
				account.password 
			FROM account  
			INNER JOIN persoon  
			ON persoon.account_id = account.id 
			WHERE username = :username
		";
		echo $sql;

		// prepare returns an empty statement object. there is no data stored in $stmt.
		$stmt = $this->db->prepare($sql);
		// execute prepared statement. pass arg, which is an associative array. 
		// key should match replacement field on line 168 (:username)!!
		$stmt->execute(['username'=>$username]);

		// fetch should return an associative array (key, value pair)
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		// check $result is an array
		if(is_array($result)){
		echo '1';
			// apply count on if $result is an array (and thus if user exists, only existing users should be able to login)
			if(count($result) > 0){
			echo '2';
				// get hashed_password from database result with key 'password'
				$hashed_password = $result['password'];
				var_dump( password_verify($password, $hashed_password));

				// verify that user exists and that provided password is the same as the hashed password
				if($username && password_verify($password, $hashed_password)){
					session_start();
	
					// store userdata in session variable (=array)
					$_SESSION['account_id'] = $result['account_id'];
					$_SESSION['person_id'] = $result['person_id'];
					$_SESSION['username'] = $username;
					$_SESSION['usertype'] = $result['type_id'];
					$_SESSION['loggedin'] = true;
	
					// check if user is an administrator. If so, redirect to the admin page.
					// if not administrator, redirect to user page.
					if($this->is_admin($username)){
						header("location: welcome_admin.php");
						//make sure that code below redirect does not get executed when redirected.
						exit;
					}

					// redirect user to the user-page if not admin.
					header("location: welcome_user.php");
					exit;
				}else{
					// returned an error message to show in span element in login form (index.php).
					return "Incorrect username and/or password. Please change your input and try again.";
				}
			}
		}else{
			// no matching user found in db. Make sure not to tell the user directly.
			return "Failed to login. Please try again";
		}
	}

/*	public function show_profile_details_user($username){

		$sql = "
			SELECT a.id, u.type, p.first_name, p.middle_name, p.last_name, a.username, a.email 
			FROM person as p 
			LEFT JOIN account as a
			ON p.account_id = a.id
			LEFT JOIN usertype as u
			ON a.type_id = u.id       
		";

		if($username !== NULL){
			// query for specific user when a username is supplied
			$sql .= 'WHERE a.username = :username';
		}

		$stmt = $this->db->prepare($sql);

		// check if username is supplied, if so, pass assoc array to execute
		$username !== NULL ? $stmt->execute(['username'=>$username]) : $stmt->execute();
		
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
	}*/

	public function getAccountInformation($id){
		$statement = $this->db->prepare("SELECT * FROM account WHERE id=:id");
		$statement->execute(['id'=>$id]);
		$account = $statement->fetch(PDO::FETCH_ASSOC);
		return $account;
	}

	public function getPersoonInformation($id){
		$statement = $this->db->prepare("SELECT * FROM persoon WHERE id=:id");
		$statement->execute(['id'=>$id]);
		$account = $statement->fetch(PDO::FETCH_ASSOC);
		return $account;
	}

	public function get_user_information($username){

		$sql = "
			SELECT 
				account.id, 
				persoon.id as persoon_id,
				usertype.type, 
				persoon.voornaam, 
				persoon.tussenvoegsel, 
				persoon.achternaam, 
				account.username, 
				account.email 
			FROM persoon 
			INNER JOIN account 
			ON persoon.account_id = account.id
			INNER JOIN usertype 
			ON account.type_id = usertype.id       
		";

		if($username !== NULL){
			// query for specific user when a username is supplied
			$sql .= 'WHERE account.username = :username';
		}

		$stmt = $this->db->prepare($sql);

		// check if username is supplied, if so, pass assoc array to execute
		$username !== NULL ? $stmt->execute(['username'=>$username]) : $stmt->execute();
		
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
	}

	public function deleteUser($account_id, $persoon_id){
		echo $account_id, $persoon_id;
		try{
			$this->db->beginTransaction();

			$stmt = $this->db->prepare("DELETE FROM persoon WHERE id=:id");
			$stmt->execute(['id'=>$persoon_id]);

			$stm = $this->db->prepare("DELETE FROM account WHERE id=:id");
			$stmt->execute(['id'=>$account_id]);

			$this->db->commit();

		}catch(PDOexception $e){
			$this->db->rollback();
			echo 'Error: '.$e->getMessage();
		}
	}
}

?>