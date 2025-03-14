<?php

/****************************************
 ../api/quotes/read_single.php
*****************************************/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$quote = new Quote($db);

// Get ID from URL
$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get quote
$quote->read_single();

// Check if quote exits
if ($quote->quote !== null) {
  // Create array
  $quote_arr = array(
    'id' => $quote->id,
    'quote' => html_entity_decode($quote->quote),
    //'author_id' => $quote->author_id,
    'author' => $quote->author_name,
    //'category_id' => $quote->category_id,
    'category' => $quote->category_name,
    );

  // Make JSON
  print_r(json_encode($quote_arr));
} else {

  // Display message if specific quote is not found
  echo json_encode(array('message' => 'No Quotes Found'));
}

?>