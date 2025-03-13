<?php

/****************************************
 ../api/quotes/update.php
*****************************************/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
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
if ( empty($data->id) || empty($data->quote) || empty($data->author_id) || empty($data->category_id) ) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit(); // Exit the script if parameters are missing
}

$quote->id          = $data->id;
$quote->quote       = $data->quote;
$quote->author_id   = $data->author_id;
$quote->category_id = $data->category_id;

if ($quote->update()) {
	$updated_quote_arr = array("id" => $quote->id, "quote" => $quote->quote, "author_id" => $quote->author_id, "category_id" => $quote->category_id );
	print_r(json_encode($updated_quote_arr));
} else {
	echo json_encode(array("message" => "Quote id {$quote->id} was not found"));
	//echo json_encode(array('message' => 'Category Not Updated'));
}

?>