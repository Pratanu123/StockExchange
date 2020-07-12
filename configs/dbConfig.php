<?php
	class dbConfig{
		private $dbHost="mysql:host=localhost;dbname=stockExchange";
		private $dbUsername="root";
		private $dbPass="";
		private $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
		protected $dbconn;
		public function getConnection(){
			try{
				$this->dbconn=new PDO($this->dbHost,$this->dbUsername,$this->dbPass,$this->options);
				return $this->dbconn;
			}
			catch(PDOException $e){
				echo "There is some problem in connection ".$e->getMessage();
			}
		}
		public function closeConnection(){
			$this->dbconn=null;
		}
	}
?>