
<?php

/****************************************
 ../api/authors/read.php
*****************************************/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate database
$database = new Database();
$db = $database->connect();

// Instantiate author object
$author = new Author($db);

// Retrieve authors
$result = $author->read();

// Get a row count on what is returned from DB
$num = $result->rowCount();

// Check if any records were returned
if ($num > 0) {
	
	$authors_arr = array();
	//$authors_arr['data'] = array();
	
	// Fetch DB results as an associative array
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		
		extract($row);

		$author_item = array(
		   'id' => $id,
		   'author' => $author 
		);

		// Push to 'data'
		//array_push($authors_arr['data'], $author_item);
		// Push to authors array directly
		array_push($authors_arr, $author_item);
	}
	
	// Convert results from a PHP associative array into JSON format
	echo json_encode($authors_arr);
} else {
	echo json_encode(array('message' => 'No Authors Found'));
}

?>