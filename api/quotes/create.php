<?php

/****************************************
 ../api/quotes/create.php
*****************************************/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, ' .
       'Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$quote = new Quote($db);

// Get raw quote data
$data = json_decode(file_get_contents("php://input"));

// Check for missing parameters
if (empty($data->quote) || empty($data->author_id) || empty($data->category_id) ) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit(); // Exit the script if parameters are missing
}

// Assign raw data to the corresponding quote object attribute
$quote->quote       = $data->quote;
$quote->author_id   = $data->author_id;
$quote->category_id = $data->category_id;

// Create the quote
if ($quote->create()) {
	// Should know the new quote id at this point from the DB, so echo it back in the JSON object
	$new_quote_arr = array("id" => $quote->id, "quote" => $quote->quote, "author_id" => $quote->author_id, "category_id" => $quote->category_id);

    //$new_quote_arr = array("id" => $quote->id, "quote" => $quote->quote, "author_id" => $quote->author_id, "category_id" => $quote->category_id);
	print_r(json_encode($new_quote_arr));
} else {
	echo json_encode(array('message' => 'Quote Not Created'));
}

?>