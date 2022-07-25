<?php

namespace classes\connection;

use mysqli;

class Connection
{
	private $conn_servername;
	private $conn_username;
	private $conn_password;
	private $conn_dbname;
	private $conn;
	
	public function __construct(){
		$this->conn_servername = "localhost";
		$this->conn_username = "root";
		$this->conn_password = "";
		$this->conn_dbname = "devstar";

		$this->conn = new mysqli($this->conn_servername, $this->conn_username, $this->conn_password, $this->conn_dbname);

		$this->conn->set_charset('utf-8');

		ob_start();

		if ($this->conn_username != "root") {
			session_save_path("/tmp");
		}

		if ($this->conn->connect_error) {
			die("There is an error in the connection: " . $this->conn->connect_error);
		}
	}

	public function getConnectionString(){

		return $this->conn;
	}

	public function __destruct(){
		
		$this->conn->close();
	}
}