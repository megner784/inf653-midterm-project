<?php

/****************************************
 ../models/Quote.php
*****************************************/

class Quote {

   private $conn;
   private $table = 'quotes';
   
   public $id;
   public $quote;
   public $author_id;
   public $category_id;
   public $category_name;
   public $author_name;
   
   public function __construct($db) {
	   $this->conn = $db;
   }
   
   /******************************************
     OOP methods for supporting CRUD operations
   *******************************************/

    // Read/retrieve all quotes
    public function read() {
	
	   $query = 'SELECT q.id, q.quote, q.author_id, q.category_id, a.author AS author_name, 
                 c.category As category_name
                 FROM ' . $this->table . ' q
                 LEFT JOIN authors a ON q.author_id = a.id 
                 LEFT JOIN categories c ON q.category_id = c.id';

	   // Prepare the statement
	   $stmt = $this->conn->prepare($query);
	
	   // Execute query
	   $stmt->execute();
	
	   return $stmt;
    }

    // Read/retrieve a specific quote based on id
    public function read_single() {
	
      $query = 'SELECT q.id, q.quote, q.author_id, q.category_id, a.author AS author_name, 
        c.category As category_name 
        FROM ' . $this->table . ' q
        LEFT JOIN authors a ON q.author_id = a.id 
        LEFT JOIN categories c ON q.category_id = c.id WHERE q.id = ? LIMIT 1';
	
	   // Prepare statement
	   $stmt = $this->conn->prepare($query);
	   
       if ( isset($this->id) && !empty($this->id) ) {

            // Bind the quote id
	        $stmt->bindParam(1, $this->id);

            // Execute the query
            $stmt->execute();
            
            // Fetch the quote
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Check if a row was returned
            if ($row) {
                // Set properties
                $this->quote = $row['quote'];
                $this->author_id = $row['author_id'];
                $this->author_name = $row['author_name'];
                $this->category_id = $row['category_id'];
                $this->category_name = $row['category_name'];
            } else {
                // Handle case where no quote is found
                $this->quote = null;
            }
       } else {
         $this->quote = null;
       }
    }
	
    // Read/retrieve quotes based on either the author_id, category_id or both
    public function read_filtered($author_id = null, $category_id = null) {
	
        $query = 'SELECT q.id, q.quote, q.author_id, q.category_id, a.author AS author_name, 
          c.category AS category_name
          FROM ' . $this->table . ' q
          LEFT JOIN authors a ON q.author_id = a.id 
          LEFT JOIN categories c ON q.category_id = c.id  ';
      
         // Initialize an array to hold query conditions
         // NOTE: the conditions[] array will hold either the author_id and/or 
         //       category_id depending on their existence.
         $conditions = array();

         // Add conditions based on provided parameters if any exist
         if ($author_id) {
            $conditions[] = ' q.author_id = :author_id';
         }

         if ($category_id) {
            $conditions[] = ' q.category_id = :category_id';
         }

        ////////////////////////////////////////////////////////////////////////
        // Append conditions to the query if any exist.
        // NOTE: The if statement checks if the $conditions array is not empty. 
        // Since it contains one element, the condition is true.
        //
        // The implode(' AND ', $conditions) function is called. Since there is 
        // only one element in the array, implode simply returns that element as 
        // a string without adding AND.  
        // 
        // The resulting string q.category_id = :category_id 
        // is appended to the base query with a WHERE clause.
        /////////////////////////////////////////////////////////////////////////
        if (!empty($conditions)) {
           $query .= ' WHERE ' . implode(' AND ', $conditions);
        }

        /*********** For Debugging  Purposes ******************
        echo "<br>";
        echo print_r($conditions);
        echo "<br>";
        echo "Query statement: ${query}";
        echo "<br>";
        *******************************************************/

         // Prepare statement
         $stmt = $this->conn->prepare($query);
         
         // Bind the parameters if any exist
         if ($author_id) {
            $stmt->bindParam(':author_id', $author_id, PDO::PARAM_INT);
         }
      
         if ($category_id) {
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
         }

         // Execute the query
         $stmt->execute();
      
         return $stmt;

    }

	// Create a new quote
    public function create() {
	
	   // Create query
	   $query = 'INSERT INTO ' . $this->table . ' 
       (quote, author_id, category_id) VALUES (:quote, :author_id, :category_id) RETURNING id';
	
	   // Prepare the statement
	   $stmt = $this->conn->prepare($query);
	   
	   // Clean the data
	   $this->quote       = strip_tags($this->quote);
       $this->author_id   = htmlspecialchars( strip_tags($this->author_id));
       $this->category_id = htmlspecialchars( strip_tags($this->category_id));

	   // Bind data
	   $stmt->bindParam(':quote', $this->quote);
       $stmt->bindParam(':author_id', $this->author_id);
       $stmt->bindParam(':category_id', $this->category_id);

	   // Execute query
	   if ($stmt->execute()) {

            // Debugging: Check if the query returned a result
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $this->id = $row['id'];
                //$this->id = $this->conn->lastInsertId();
                return true;
            } else {
                echo "No ID returned.";
            }
        } else {
            echo "Query execution failed.";
        }
	   
	   return false;
    }
	
	// Update an existing quote
    public function update() {
	
		// Check if the id exists in the database
		$checkQuery = 'SELECT COUNT(*) FROM ' . $this->table . ' WHERE id = :id';
		$checkStmt = $this->conn->prepare($checkQuery);
		$checkStmt->bindParam(':id', $this->id);
		$checkStmt->execute();
	
		// Fetch the count
		$count = $checkStmt->fetchColumn();
		
		// If the id exists, proceed with the quote update
		if ($count > 0) {

            // Set up the UPDATE query
			$query = 'UPDATE ' . $this->table . ' 
            SET quote = :quote, author_id = :author_id,
            category_id = :category_id  WHERE id = :id';
			
			$stmt = $this->conn->prepare($query);

            // Clean the data
			$this->id           = htmlspecialchars( strip_tags($this->id));
            $this->quote        = strip_tags($this->quote);
            $this->author_id    = htmlspecialchars( strip_tags($this->author_id));
            $this->category_id  = htmlspecialchars( strip_tags($this->category_id));

            // Bind the data
            $stmt->bindParam(':id', $this->id);
			$stmt->bindParam(':quote', $this->quote);
			$stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

            // Eecute the UPDATE query
			if ($stmt->execute()) {
				return true;
			}
		}
	
		// If the id does not exist, return false
		return false;
	}
	
	// Delete an existing quote
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