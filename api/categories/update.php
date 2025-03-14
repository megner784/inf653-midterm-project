<?php

/****************************************
 ../api/categories/update.php
*****************************************/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
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
if (empty($data->id) || empty($data->category)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit(); // Exit the script if parameters are missing
}

$cat->id       = $data->id;
$cat->category = $data->category;

if ($cat->update()) {
	$updated_cat_arr = array("id" => $cat->id, "category" => $cat->category);
	print_r(json_encode($updated_cat_arr));
} else {
	echo json_encode(array("message" => "category_id Not Found"));
	//echo json_encode(array("message" => "category_id {$cat->id} was not found"));
	//echo json_encode(array('message' => 'Category Not Updated'));
}

?>