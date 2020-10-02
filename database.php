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

	public function addAccount($email, $password){
		
		try{
			//beginnen aan transactie			
			$this->db->beginTransaction();
			echo "begin transatie";
			$pdo1 = "INSERT INTO account('id', 'email', 'password') VALUES (?,?,?)";
			echo "sql statement: ".$pdo1;
			$stmt = $this->db->prepare($pdo1);
			print_r($pdo1);
			$stmtExcecute = $stmt->execute(['id'=>NULL,'email'=>$email, 'password'=>$password]);
			$this->db->commit();
		}catch (Exception $a){
			$this->db->rollback();
			throw $a;
		}
	}	
	/*public function executeQueryExample(){
	
		$sql = 'SELECT * FROM account WHERE email=$email AND status=$status';
		$statement = $this->db->prepare($query);
		$statement->execute();
		$statement->fetch();

		$sql = 'SELECT * FROM account WHERE email=? AND status=?';
		$statement = $this->db->prepare($query);
		$statement->execute([$email, $status]);
		$statement->fetch();

		$sql = 'SELECT * FROM account WHERE email=:email AND status=:status';
		$statement = $this->db->prepare($query);
		$statement->execute(['email' => $email, 'status' => $status]);
		$statement->fetch();
	}*/

}
?>