<?php

/****************************************
 ../api/categories/read_single.php
*****************************************/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate category object
$cat = new Category($db);

// Get ID from URL
$cat->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get category
$cat->read_single();

// Check if category exits
if ($cat->category !== null) {
  // Create array
  $cat_arr = array(
    'id'       => $cat->id,
    'category' => $cat->category
  );

  // Make JSON
  print_r(json_encode($cat_arr));
} else {

  // Display message if specific category is not found
  echo json_encode(array('message' => 'category_id Not Found'));
}

?>