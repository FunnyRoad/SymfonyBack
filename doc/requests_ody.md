#API Documentation 
The following API will permise you to manage roadsTrips using FunnyRoad application.

##Api summary:
* Entity Place:
 * Create place
 * Update place
 * Find place
 * Find all places
 * Delete place


api-base-path:
* dev : localhost:8000
* prod : ????

###################################################################################
# Place 

## Create Place
HTTP Request <return>
Method: POST <return>
Url: {api-base-path}/place <return>
{      <return>
	"name":"Ma place", // Place name <return>     
	"description":"Custom description", //Place description <return>     
	"grade":9, //Place grade <return>
} <return>

## Update place
HTTP Request <return>
Method: PUT <return>
Url: {api-base-path}/place <return>
{      <return>
	"id",2,  // Place id <return>
	"name":"Ma place", // Place name      <return>
	"description":"Custom description", //Place description      <return>
	"grade":9, //Place grade <return>
} <return>

## Find all places

HTTP Request <return>
Method: GET <return>
Url: {api-base-path}/place <return>


## Find all one place

HTTP Request <return>
Method: GET <return>
Url: {api-base-path}/place/{place_id} <return>


## Delete place

HTTP Request <return>
Method: DELETE <return>
Url: {api-base-path}/place/{place_id} <return>


