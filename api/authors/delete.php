<?php

/****************************************
 ../api/authors/delete.php
*****************************************/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, ' .  
      'Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate author object
$author = new Author($db);

// Get raw author data
$data = json_decode(file_get_contents("php://input"));

// Check for missing parameters
if (empty($data->id)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit(); // Exit the script if parameters are missing
}

$author->id     = $data->id;

if ($author->delete()) {
	// Per instructions just report back the id that was deleted
	echo json_encode(array("id" => " {$author->id} "));
	//echo json_encode(array("message" => "author_id {$author->id} was deleted"));
	//echo json_encode(array('message' => 'Author Deleted'));
} else {
	echo json_encode(array("message" => "author_id {$author->id} was not found"));
}

?>