#API Documentation 
The following API will permise you to manage roadsTrips using FunnyRoad application.

##Api summary:
* Entity Place:
  * Create place
  * Update place
  * Find place
  * Find all places
  * Delete place
  
* Entity RoadTrip 
  * Create roadtrip
  * Update roadtrip
  * Find roadtrip
  * Find all roadtrips
  * Find places of roadtrip
  * Delete roadtrip
  * Delete one place from a roadtrip

api-base-path:  
* dev : localhost:8000  
* prod : vps376653.ovh.net:8080    


# Place 

### Create Place
HTTP Request  
Method: POST  
Url: {api-base-path}/place  
```json
{  
	"name":"Ma place", // Place name  
	"description":"Custom description", //Place description  
	"grade":9 //Place grade  
}  
```
### Update place
HTTP Request  
Method: PUT  
Url: {api-base-path}/place  
```json
{  
	"id":2,  // Place id  
	"name":"Ma place", // Place name  
	"description":"Custom description", //Place description  
	"grade":9 //Place grade  
}  
```
### Find one place

HTTP Request  
Method: GET  
Url: {api-base-path}/place/{place_id}  

Return json content

```json
{  
	"id":2,  // Place id  
	"name":"Ma place", // Place name  
	"description":"Custom description", //Place description  
	"grade":9 //Place grade  
}  
```


### Find all places

HTTP Request  
Method: GET  
Url: {api-base-path}/place  

Return Json array with list of places

### Delete place

HTTP Request  
Method: DELETE  
Url: {api-base-path}/place/{place_id}  


#RoadTrip


### Create Roadtrip
HTTP Request  
Method: POST  
Url: {api-base-path}/roadtrip
```json
{  
	"name":"Ma place", // Roadtrip name  
	"places":[1,2...] //list of places id of a roadtrip
}  
```
### Update roadtrip
HTTP Request  
Method: PUT  
Url: {api-base-path}/roadtrip  
```json
{  
	"name":"Ma place" // Roadtrip name  
}  
```
If you send json without list of places, only roadtrip name will be updated
or  
```json
{  
	"name":"Ma place", // Roadtrip name  
	"places":[1,2...] //list of places id of a roadtrip
}  
```
If you send list of places id, the old list will be cleared and replaced by the new one (the list you sent)  

### Find  roadtrip

HTTP Request  
Method: GET  
Url: {api-base-path}/roadtrip/{roadtripId}  

return json content

```json
{  
	"name":"Ma place", // Roadtrip name  
	"places":[1,2...] //list of places id of a roadtrip
}  
```


### Find all roadtrips

May be a not important endpoint, it will probably be replaced  
  
HTTP Request  
Method: GET  
Url: {api-base-path}/place/{place_id}  

return json array which contains list of roadtrips

### Find places of roadtrip

HTTP Request
Method : GET
Url: {api-base-path}:/roadtrip/{roadtripId}/places

return json array which contains list of places

### Delete roadtrip

HTTP Request  
Method: DELETE  
Url: {api-base-path}/roadtrip/{place_id}  
 
### Delete one place from roadtrip

HTTP Request
Method: DELETE
URL: {api-base-path}/roadtrip/{roadtripId}/place/{placeId}


