# Quotes REST API


This project is a PHP OOP REST API designed to manage quotations, including both famous quotes and user submissions. 
The API is developed using PHP and PostgreSQL database.</P>

### Developer
Michael Egner  

### Project Location and Routes
https://inf653-midterm-project-aj1k.onrender.com  

https://inf653-midterm-project-aj1k.onrender.com/api/quotes/  

https://inf653-midterm-project-aj1k.onrender.com/api/authors/  

https://inf653-midterm-project-aj1k.onrender.com/api/categories/  

### API Endpoints

#### Authors
GET /api/authors/ ...................... Retrieve all authors.  
GET /api/authors/?id={id} .............. Retrieve a specific author by ID.  
POST /api/authors/ ....................  Create a new author.  
PUT /api/authors/ .....................  Update an existing author.  
DELETE /api/authors/ ..................  Delete an author.  


#### Categories
GET /api/categories/ .................. Retrieve all categories.  
GET /api/categories/?id={id} .......Retrieve a specific category by ID.  
POST /api/categories/ ................Create a new category.  
PUT /api/categories/ ...................Update an existing category.  
DELETE /api/categories/ ............Delete a category.  

#### Quotes
GET /api/quotes/ ..............................................Retrieve all quotes.  
GET /api/quotes/?id={id} ..................................Retrieve a specific quote by ID.  
GET /api/quotes/?author_id={author_id} ..........Retrieve quotes by author ID.  
GET /api/quotes/?category_id={category_id} ...Retrieve quotes by category ID.  

GET /api/quotes/?author_id={author_id}&category_id={category_id} ...Retrieve quotes by author_id and category_id  

POST /api/quotes/ .............................................Create a new quote.  
PUT /api/quotes/?id={id}  .....................................Update an existing quote.  
DELETE /api/quotes/?id={id} ...................................Delete a quote.  

### Usage

To use the API, send HTTP requests to the appropriate endpoints. For example, to retrieve all quotes,   
send a GET request to /api/quotes/.  

#### Example Request:    
To retrieve a specific quote with id=1, issue the following:  
https://inf653-midterm-project-aj1k.onrender.com/api/quotes/?id=1  

#### Example Response:

{  
  "id": "1",  
  "quote": "Our greatest weakness lies in giving up. The most certain way to succeed is always to try just one more time.",  
  "author": "Thomas A. Edison",  
  "category": "Motivational"  
}  

