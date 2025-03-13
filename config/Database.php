<?php

/*******************************************************************************
 
// Use the following Database class for local PostgreSQL connection on client PC

class Database {

    //DB Params
    private $host     = 'localhost';
    private $port     = 5432;
    private $db_name  = 'quotesdb';
    private $username = 'postgres';
    private $password = '123';
    private $conn;

    // DB Connection
    public function connect() {
        $this->conn = null;

        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}";

        try {
            $this->conn = new PDO($dsn, $this->username, $this->password);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {
            // echo for tutorial, but log the error for production
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}

************************************************************************************/

// Use the following Database class for Render.com PostgreSQL connection on the cloud
class Database {

    //DB Params
    private $host;
    private $port;
    private $dbname;
    private $username;
    private $password;
    private $conn;

    public function __construct() {
		$this->username = getenv('USERNAME');
		$this->password = getenv('PASSWORD');
		$this->dbname   = getenv('DBNAME');
		$this->host     = getenv('HOST');
        $this->port     = 5432;               // PostgreSQL runs on port 5432, NOT 10000
		// $this->port     = getenv('PORT');
	}
    // DB Connection
    public function connect() {
        // instead of $this->conn = null;
		
		if ($this->conn) {
			// connection already exists, return iterator_apply
			return $this->conn;
		} else {
			
			$dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname};sslmode=require";

			try {
				$this->conn = new PDO($dsn, $this->username, $this->password);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo "Database connection successful!";
                return $this->conn;
			} catch(PDOException $e) {
				// echo for tutorial, but log the error for production
				echo 'Connection Error: ' . $e->getMessage();
			}
		}
    }
}

?>