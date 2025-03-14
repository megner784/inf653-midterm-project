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
include_once '../../models/Author.php';
include_once '../../models/Category.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$quote = new Quote($db);

// Instantiate author object
$author = new Author($db);

// Instantiate category object
$category = new Category($db);

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

// Check if the author exists
$authorExists = $author->authorExists($data->author_id);

// Check if the category exists
$categoryExists = $category->categoryExists($data->category_id);

// Handle the case where either or both the author_id and category_id do not exist
if (!$authorExists && !$categoryExists) {
    echo json_encode(array('message' => 'Both author_id and category_id Not Found'));
    exit(); // Exit the script if both author_id and category_id are not found
} elseif (!$authorExists) {
    echo json_encode(array('message' => 'author_id Not Found'));
    exit(); // Exit the script if author_id is not found
} elseif (!$categoryExists) {
    echo json_encode(array('message' => 'category_id Not Found'));
    exit(); // Exit the script if category_id is not found
}

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