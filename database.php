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
			// connectie with database			
			$dsn = "mysql:host=$this->host;dbname=$this->database;charset=$this->charset";
			$this->db = new PDO($dsn, $this->username, $this->password);
			$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			echo 'Succesfully connected'."<br>";
		}	// catch error
		catch(PDOexception $e){
			echo $e->getMessage();
			exit('An error occurred');
		}
	}

	public function addAccount($voornaam, $tussenvoegsel, $achternaam, $email, $username, $password){
		
		try{
			//transaction 			
			$this->db->beginTransaction();
			echo "begin transatie"."<br>";		
			
					/*$type_id = "SELECT id FROM usertype WHERE type='admin'";
					$stmt = $this->db->prepare($type_id);
					$stmt->bindParam(':type_id', $type_id);
					$stmt->execute([]);*/


			//2 is account		
			$sql1 = "INSERT INTO account(id, username, email, type_id, password, created_at, updated_at ) 
				VALUES(:id, :username, :email, :type_id, :password, :created_at, :updated_at)";
			echo "sql statement: ".$sql1."<br>";
			// prepare
			$stmt1 = $this->db->prepare($sql1);
					/* $stmt1->bindParam(':username', $username);
					$stmt1->bindParam(':email', $email);
					$stmt1->bindParam(':type_id', $type_id);
					$created_at = date("Y-m-d H:i:s");
					$updated_at = date("Y-m-d H:i:s");
					$stmt1->bindParam(':created_at', $created_at);
					$stmt1->bindParam(':updated_at', $updated_at);

					$hashPassword = password_hash($password, PASSWORD_DEFAULT);
					$stmt1->bindParam(':password', $hashPassword);
					*/			
			$type_id = 1;
			$hashPassword = password_hash($password, PASSWORD_DEFAULT);
			//execute
			$stmt1->execute(['id' => NULL, 'email'=>$email, 'type_id'=>$type_id, 'username'=>$username, 'password'=>$hashPassword, 'created_at'=>date("Y-m-d H:i:s"), 'updated_at'=>date("Y-m-d H:i:s")]);
											
			//3 is persoon			
			$sql2 = "INSERT INTO persoon (id, account_id, voornaam, tussenvoegsel, achternaam, created_at, updated_at) 
				VALUES (:id, :account_id, :voornaam,:tussenvoegsel,:achternaam, :created_at, :updated_at)";
			echo "sql statement: ".$sql2."<br>";
			//prepare
			$stmt2 = $this->db->prepare($sql2);			
			//execute
			$stmt2->execute(['id' => NULL, 'account_id'=>NULL, 'voornaam'=>$voornaam,'tussenvoegsel'=>$tussenvoegsel, 'achternaam'=>$achternaam, 'created_at'=>date("Y-m-d H:i:s"), 'updated_at'=>date("Y-m-d H:i:s")]);
			//commiten (dit hoeft maar een keer voor de hele transactie)
			$this->db->commit();
			echo "gelukt";
		}
		catch (PDOexception $a){
			echo $a->getMessage();
			$this->db->rollback();
			throw $a;
			
		}
	}		
}
?>