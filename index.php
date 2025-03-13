<?php
   header('Content-Type: text/html; charset=UTF-8');
   ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP REST Quotes API</title>
</head>

<body>
    <h1>Welcome to the PHP REST Quotes API</h1>
    <p>This API allows you to manage quotes, authors, and categories.</p>
    <h2>Available Endpoints</h2>
    
    <ul>
        <li><pre><strong>Quotes:</strong>          /api/quotes/</pre></li>
        <li><pre><strong>Authors:</strong>         /api/authors/</pre></li>
        <li><pre><strong>Categories:</strong>      /api/categories/</pre></li>
    </ul>
    
    <h2>Usage</h2>
    <p>Use the following endpoints to interact with the API:</p>
    <ul>
        <li><strong>GET</strong> <code>/api/quotes/</code> - Retrieve all quotes</li>
        <li><strong>GET</strong> <code>/api/quotes/?id=4</code> - Retrieve a specific quote by ID</li>
        <li><strong>POST</strong> <code>/api/quotes/</code> - Create a new quote</li>
        <li><strong>PUT</strong> <code>/api/quotes/</code> - Update an existing quote</li>
        <li><strong>DELETE</strong> <code>/api/quotes/</code> - Delete a quote</li>
        <li><strong>GET</strong> <code>/api/authors/</code> - Retrieve all authors</li>
        <li><strong>GET</strong> <code>/api/authors/?id=4</code> - Retrieve a specific author by ID</li>
        <li><strong>POST</strong> <code>/api/authors/</code> - Create a new author</li>
        <li><strong>PUT</strong> <code>/api/authors/</code> - Update an existing author</li>
        <li><strong>DELETE</strong> <code>/api/authors/</code> - Delete an author</li>
        <li><strong>GET</strong> <code>/api/categories/</code> - Retrieve all categories</li>
        <li><strong>GET</strong> <code>/api/categories/?id=4</code> - Retrieve a specific category by ID</li>
        <li><strong>POST</strong> <code>/api/categories/</code> - Create a new category</li>
        <li><strong>PUT</strong> <code>/api/categories/</code> - Update an existing category</li>
        <li><strong>DELETE</strong> <code>/api/categories/</code> - Delete a category</li>
    </ul>
    
    <p>For more information, please refer to the documentation.</p>
    
</body>
</html>