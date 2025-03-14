<?php

/****************************************
 ../api/quotes/delete.php
*****************************************/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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
if (empty($data->id)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit(); // Exit the script if parameters are missing
}

$quote->id     = $data->id;

if ($quote->delete()) {
	// Per instructions just report back the id that was deleted
	echo json_encode(array("id" => " {$quote->id} "));
} else {
	//echo json_encode(array("message" => "Quote id {$quote->id} was not found"));
    echo json_encode(array("message" => "No Quotes Found"));
}

?>