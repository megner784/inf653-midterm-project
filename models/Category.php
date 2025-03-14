<?php

/****************************************
 ../models/Category.php
*****************************************/

class Category {

   private $conn;
   private $table = 'categories';
   
   public $id;
   public $category;
   
   public function __construct($db) {
	   $this->conn = $db;
   }
   
   /******************************************
     OOP methods for supporting CRUD operations
   *******************************************/

    // Read/retrieve all categories
    public function read() {
	
	   $query = 'SELECT id, category FROM ' . $this->table;
	
	   // Prepare the statement
	   $stmt = $this->conn->prepare($query);
	
	   // Execute query
	   $stmt->execute();
	
	   return $stmt;
    }

    // Read/retrieve a specific category based on id
    public function read_single() {
	
	   $query = 'SELECT id, category FROM ' . $this->table . ' WHERE id = ? LIMIT 1';
	
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
         $this->category = $row['category'];
       } else {
         // Handle case where no category is found
         $this->category = null;
       }

    }
	
    // Check if category exists
    public function categoryExists($id) {
      $query = 'SELECT COUNT(*) AS count FROM ' . $this->table . ' WHERE id = :id';
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      // Bind the category id
      $stmt->bindParam(':id', $id);
      // Execute query
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
      // Return true if category exists, else false
      return $row['count'] > 0;
   }

	// Create a new category
    public function create() {
	
	   // Create query
	   $query = 'INSERT INTO ' . $this->table . ' (category) VALUES (:category)';
	
	   // Prepare the statement
	   $stmt = $this->conn->prepare($query);
	   
	   // Clean the data
	   $this->category = htmlspecialchars( strip_tags($this->category));
	   
	   // Bind data
	   $stmt->bindParam(':category', $this->category);
	
	   // Execute query
	   if ($stmt->execute()) {
        // Get the last inserted id to for reporting in json_encode()
        $this->id = $this->conn->lastInsertId();
        return true;
       }
	   
	   return false;
	  
    }
	
    // Update an existing category
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
            $query = 'UPDATE ' . $this->table . ' SET category = :category WHERE id = :id';
           
            $stmt = $this->conn->prepare($query);

            $this->category = htmlspecialchars( strip_tags($this->category));
            $this->id       = htmlspecialchars( strip_tags($this->id));
    
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':id', $this->id);
         
            if ($stmt->execute()) {
               return true;
            }
        }
     
        // If the id does not exist, return false
        return false;
     }

	// Delete an existing category
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
           // Clean ID
           $this->id = htmlspecialchars(strip_tags($this->id));
           // Bind ID
           $stmt->bindParam(':id', $this->id);
        
           // Execute the query
           if ($stmt->execute()) {
              return true;
           }
       }
    
       // If the id does not exist, return false
       return false;
	}
}

?>