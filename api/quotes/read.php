<?php

/****************************************
 ../api/quotes/read.php
*****************************************/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate database and connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$quote = new Quote($db);

// Retrieve quotes
$result = $quote->read();

// Get a row count on what is returned from DB
$num = $result->rowCount();

// Check if any records were returned
if ($num > 0) {
	
	$quotes_arr = array();
	//$quotes_arr['data'] = array();
	
	// Fetch DB results as an associative array
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		
		extract($row);

		$quote_item = array(
		   'id' => $id,
		   'quote' => html_entity_decode($quote),
           //'author_id' => $author_id,
           'author' => $author_name,
           //'category_id' => $category_id,
           'category' => $category_name,
		);

		// Push to 'data'
		//array_push($quotes_arr['data'], $quote_item);
		// Push to quotes array directly
		array_push($quotes_arr, $quote_item);
	}
	
	// Convert results from a PHP associative array into JSON format
	echo json_encode($quotes_arr);
} else {
	echo json_encode(array('message' => 'No Quotes Found'));
}

?>