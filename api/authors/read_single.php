<?php

/****************************************
 ../api/authors/read_single.php
*****************************************/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate author object
$author = new Author($db);

// Get ID from URL
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get author
$author->read_single();

// Check if author exits
if ($author->author !== null) {
  // Create array
  $author_arr = array(
    'id'     => $author->id,
    'author' => $author->author
  );

  // Make JSON
  print_r(json_encode($author_arr));
} else {

  // Display message if specific author is not found
  echo json_encode(array('message' => 'author_id Not Found'));
}










?>