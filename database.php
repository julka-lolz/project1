<?php

class database{

	private $host;
	private $username;
	private $password;
	private $database;
	private $charset;
	private $db;

	public function __construct($host,$username,$password,$database,$charset){

		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
		$this->charset = $charset;	

		try{
			// connectie aanmaken met database
			$dsn = "mysql:host=$this->host;dbname=$this->database;charset=$this->charset";
			$this->db = new PDO($dsn, $this->username, $this->password);
			echo 'Succesfully connected';
		}	// eventuele error opvangen
		catch(PDOexception $e){
			echo $e->getMessage();
			exit('An error occurred');
		}
	}

	public function addAccount($voornaam, $tussenvoegsel, $achternaam, $email, $username, $password){
		
		try{
			//beginnen aan transactie			
			$this->db->beginTransaction();

			echo "begin transatie";

			//eerste query preparen en executen
			$query = "INSERT INTO account (email, username, password) 
				VALUES ('$email','$username', '$password')";

			echo "sql statement: ".$query."<br>";
			// prepare
			$stmt = $this->db->prepare($query);
			print_r($query);
			// execute
			$stmtExcecute = $stmt->execute(['email'=>email, 'username'=>username, 'password'=>password]);		
			$this->db->commit();
			//tweede query preparen en executen
			$query2 = "INSERT INTO persoon (voornaam, tussenvoegsel, achternaam) 
				VALUES ('$voornaam','$tussenvoegsel','$achternaam')";

			echo "sql statement: ".$query2."<br>";
			//prepare
			$stmt = $this->db->prepare($query2);
			print_r($query2);
			//execute
			$stmtExcecute = $stmt->execute(['voornaam'=>$voornaam,'tussenvoegsel'=>$tussenvoegsel, 'achternaam'=>$achternaam]);
			$this->db->commit();
		}
		catch (Exception $a){
			$this->db->rollback();
			throw $a;
		}
	}		
}
?>