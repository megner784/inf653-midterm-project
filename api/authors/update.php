<?php

/****************************************
 ../api/authors/update.php
*****************************************/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, ' .   
       'Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate database
$database = new Database();
$db = $database->connect();

// Instantiate author object
$author = new Author($db);

// Get raw author data
$data = json_decode(file_get_contents("php://input"));

// Check for missing parameters
if (empty($data->id) || empty($data->author)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit(); // Exit the script if parameters are missing
}

$author->id     = $data->id;
$author->author = $data->author;

if ($author->update()) {
	$updated_author_arr = array("id" => $author->id, "author" => $author->author);
	print_r(json_encode($updated_author_arr));
	//echo json_encode(array('message' => 'updated author (id, author)'));
} else {
	echo json_encode(array("message" => "author_id Not Found"));
	//echo json_encode(array("message" => "author_id {$author->id} was not found"));
	//echo json_encode(array('message' => 'Author Not Updated'));
}

?>