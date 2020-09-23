<?php

class database{

	private $host;
	private $username;
	private $password;
	private $database;
	private $charset;
	private $db;

	public function __construct($host,$username,$password,$database,$charset,$db){
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
		$this->charset = $charset;
		$this->db = $db;

		try{
		
			$dsn = "mysql:host=$this->host;dbname=$this->database;charset=$this->charset";
			$this->db = new PDO($dns, $this->username, $this->password);
			echo 'Succesfully connected';
		}catch(PDOexception $e){
			echo $e->getMessage();
			exit('An error occurred')
		}
	}

	public function executeQueryExample(){
	
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
	}

}
?>