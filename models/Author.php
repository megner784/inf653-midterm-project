
<?php

/****************************************
 ../models/Author.php
*****************************************/

class Author {

   private $conn;
   private $table = 'authors';
   
   public $id;
   public $author;
   
   public function __construct($db) {
	   $this->conn = $db;
   }
   
   /******************************************
     OOP methods for supporting CRUD operations
   *******************************************/

    // Read/retrieve all authors
    public function read() {
	
	   $query = 'SELECT id, author FROM ' . $this->table;
	
	   // Prepare the statement
	   $stmt = $this->conn->prepare($query);
	
	   // Execute query
	   $stmt->execute();
	
	   return $stmt;
    }

    // Read/retrieve a specific author based on id
    public function read_single() {
	
	   $query = 'SELECT id, author FROM ' . $this->table . ' WHERE id = ? LIMIT 1';
	
	   // Prepare statement
	   $stmt = $this->conn->prepare($query);
	   
	   // Bind the author id
	   $stmt->bindParam(1, $this->id);
	
	   // Execute the query
	   $stmt->execute();
	
	   $row = $stmt->fetch(PDO::FETCH_ASSOC);
	   
	   // Check if a row was returned
	   if ($row) {
         // Set properties
         $this->author = $row['author'];
       } else {
         // Handle case where no author is found
         $this->author = null;
       }

    }
	
	// Create a new author
    public function create() {
	
	   // Create query
	   $query = 'INSERT INTO ' . $this->table . ' (author) VALUES (:author)';
	
	   // Prepare the statement
	   $stmt = $this->conn->prepare($query);
	   
	   // Clean the data
	   $this->author = htmlspecialchars( strip_tags($this->author));
	   
	   // Bind data
	   $stmt->bindParam(':author', $this->author);
	
	   // Execute query
	   if ($stmt->execute()) {
        // Get the last inserted id to for reporting in json_encode()
        $this->id = $this->conn->lastInsertId();
        return true;
       }
	   
	   return false;
	  
    }
	
	// Update an existing author
    public function update() {
	
		// Check if the id exists in the database
		$checkQuery = 'SELECT COUNT(*) FROM ' . $this->table . ' WHERE id = :id';
		$checkStmt = $this->conn->prepare($checkQuery);
		$checkStmt->bindParam(':id', $this->id);
		$checkStmt->execute();
	
		// Fetch the count
		$count = $checkStmt->fetchColumn();
		
		// If the id exists, proceed with update
		if ($count > 0) {
			$query = 'UPDATE ' . $this->table . ' SET author = :author WHERE id = :id';
			
			$stmt = $this->conn->prepare($query);

			$this->author = htmlspecialchars( strip_tags($this->author));
			$this->id     = htmlspecialchars( strip_tags($this->id));
	
			$stmt->bindParam(':author', $this->author);
			$stmt->bindParam(':id', $this->id);
		
			if ($stmt->execute()) {
				return true;
			}
		}
	
		// If the id does not exist, return false
		return false;
	}
	
	// Delete an existing author
    public function delete() {
	
	   // Check if the id exists in the database
       $checkQuery = 'SELECT COUNT(*) FROM ' . $this->table . ' WHERE id = :id';
       $checkStmt = $this->conn->prepare($checkQuery);
       $checkStmt->bindParam(':id', $this->id);
       $checkStmt->execute();
    
       // Fetch the count
       $count = $checkStmt->fetchColumn();
	   
	   // If the id exists, proceed with deletion
	   if ($count > 0) {
           $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
           $stmt = $this->conn->prepare($query);
           $this->id = htmlspecialchars(strip_tags($this->id));
           $stmt->bindParam(':id', $this->id);
        
           if ($stmt->execute()) {
              return true;
           }
       }
    
       // If the id does not exist, return false
       return false;
	}
}

?>