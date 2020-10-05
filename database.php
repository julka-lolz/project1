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

			$query = "INSERT INTO account (email, username, password) 
				VALUES ('$email','$username', '$password')";
			$query2 = "INSERT INTO persoon (voornaam, tussenvoegsel, achternaam) 
				VALUES ('$voornaam','$tussenvoegsel','$achternaam')";

			echo "sql statement: ".$query."<br>".$query2;

			$stmt = $this->db->prepare($query, $query2);
			print_r($query, $query2);

			$stmtExcecute = $stmt->execute(['voornaam'=>$voornaam,'tussenvoegsel'=>$tussenvoegsel, 'achternaam'=>$achternaam,  'email'=>email, 'username'=>username, 'password'=>password]);
			$this->db->commit();
		}
		catch (Exception $a){
			$this->db->rollback();
			throw $a;
		}
	}		
}
?>