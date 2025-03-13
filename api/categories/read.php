<?php

/****************************************
 ../api/categories/read.php
*****************************************/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate database and connect
$database = new Database();
$db = $database->connect();

// Instantiate category object
$cat = new Category($db);

// Retrieve categories
$result = $cat->read();

// Get a row count on what is returned from DB
$num = $result->rowCount();

// Check if any records were returned
if ($num > 0) {
	
	$cats_arr = array();
	//$cats_arr['data'] = array();
	
	// Fetch DB results as an associative array
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		
		extract($row);

		$cat_item = array(
		   'id' => $id,
		   'category' => $category 
		);

		// Push to 'data'
		//array_push($cats_arr['data'], $cat_item);
		// Push to cats array directly
		array_push($cats_arr, $cat_item);
	}
	
	// Convert results from a PHP associative array into JSON format
	echo json_encode($cats_arr);
} else {
	echo json_encode(array('message' => 'No Categories Found'));
}

?>