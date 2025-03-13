<?php

/****************************************
 ../api/categories/create.php
*****************************************/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, ' .
       'Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate category object
$cat = new Category($db);

// Get raw category data
$data = json_decode(file_get_contents("php://input"));

// Check for missing parameters
if (empty($data->category)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit(); // Exit the script if parameters are missing
}

// Assign raw data to the corresponding category object attribute
$cat->category = $data->category;

// Create the category
if ($cat->create()) {
	// Should know the new category id at this point from the DB, so echo it back in the JSON object
	$new_cat_arr = array("id" => $cat->id, "category" => $cat->category);
	print_r(json_encode($new_cat_arr));
} else {
	echo json_encode(array('message' => 'Category Not Created'));
}

?>