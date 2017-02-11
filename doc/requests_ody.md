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
HTTP Request  
Method: POST  
Url: {api-base-path}/place  
{  
	"name":"Ma place", // Place name  
	"description":"Custom description", //Place description  
	"grade":9, //Place grade <return>
}  

## Update place
HTTP Request  
Method: PUT  
Url: {api-base-path}/place  
{  
	"id",2,  // Place id  
	"name":"Ma place", // Place name  
	"description":"Custom description", //Place description  
	"grade":9, //Place grade  
}  

## Find all places

HTTP Request  
Method: GET  
Url: {api-base-path}/place  


## Find all one place

HTTP Request  
Method: GET  
Url: {api-base-path}/place/{place_id}  


## Delete place

HTTP Request  
Method: DELETE  
Url: {api-base-path}/place/{place_id}  


