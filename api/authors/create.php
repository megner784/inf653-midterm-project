<?php

/****************************************
 ../api/authors/create.php
*****************************************/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
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
if (empty($data->author)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit(); // Exit the script if parameters are missing
}

// Assign raw data to the corresponding author object attribute
$author->author = $data->author;

// Create the author
if ($author->create()) {
	// Should know the new author id at this point from the DB, so echo it back in the JSON object
	$new_author_arr = array("id" => $author->id, "author" => $author->author);
	print_r(json_encode($new_author_arr));
	//echo json_encode(array('message' => "created author ({$author->id}, {$author->author})"));
	//echo json_encode(array('message' => 'created author (id, author)'));
} else {
	//echo json_encode(array('message' => 'Author Not Created'));
	echo json_encode(array('message' => 'author_id Not Found'));
}

?>