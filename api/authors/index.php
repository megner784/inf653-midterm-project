<?php

/****************************************
 ../api/authors/index.php
*****************************************/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {

   header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
   header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
   exit();
}

/******************************************************
 Parse the request and route to the appropriate file
*******************************************************/

// Get the query parameters

$query = $_SERVER['QUERY_STRING'];
parse_str($query, $params);

// Invoke the appropriate route based on the HTTP request method

switch($method) {

   case 'GET':
      if ( isset($params['id']) ) {
	     require 'read_single.php';  // GET:  retrieve a single author using the id
	  } else {
	     require 'read.php';         // GET:  to retrieve all authors
	  }
	  break;
	  
	case 'POST':
	  require 'create.php';          // POST: create a new author
	  break;
	  
	case 'PUT':
	  require 'update.php';          // PUT: update an existing author
	  break;
	  
	case 'DELETE':
	  require 'delete.php';          // DELETE: an existing author
	  break;
	  
	default:
	  echo json_encode(array('message' => 'Invalid Request Method'));
	  break;
}

?>