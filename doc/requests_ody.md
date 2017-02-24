#API Documentation 
The following API will permise you to manage roadsTrips using FunnyRoad application.

##API Links
api-base-path:  
* dev : localhost:8000  
* preprod : vps376653.ovh.net:8080    

##Api summary:

* Entity User  
  * Create user
  * Find user
  * Delete user
  * Update user 

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

* Actions on roadtrips <-> geust
Guests are user that have been invited to roadtrip  
  * Get roadtrip guests
  * Get Roadtrips as guest of user
  * Add guest to roadtrip
  * Remove guest from roadtrip

#User

### Create user

HTTP Request  
Method: POST  
Url: {api-base-path}/user
```json
{  
	"mail":"mail address", //obligatory  
	"firebaseId":"", //obligatory  
	"firstName":"",  
	"lastName":"",  
	"username:"",  
	"birthDate":  
}  
```

Return json object which contains the created user with his symfony id


```json
{  
  	"id":"",  
	"mail":"mail address", //obligatory  
	"firebaseId":"", //obligatory  
	"firstName":"",  
	"lastName":"",  
	"username:"",  
	"birthDate":""  
}
```
###Find user
HTTP Request
Method: GET
Url: {api-base-path}/user/{id}

Return json object of the found user

###Delete user

HTTP Request
Method: GET
Url: {api-base-path}/user/{id}


###Update user 

HTTP Request  
Method: PUT  
Url: {api-base-path}/user
```json
{  
	"id":"", //Symfony id  
	"mail":"mail address", //obligatory  
	"firebaseId":"", //obligatory  
	"firstName":"",  
	"lastName":"",  
	"username:"",  
	"birthDate":  
}  
```

Return json object which contains the created user with his symfony id


```json
{  
  	"id":"",  
	"mail":"mail address", //obligatory  
	"firebaseId":"", //obligatory  
	"firstName":"",  
	"lastName":"",  
	"username:"",  
	"birthDate":""  
}
```

# Place 

### Create Place
HTTP Request  
Method: POST  
Url: {api-base-path}/place  
```json
{  
	"name":"Ma place", // Obligatory field  
	"description":"Custom description",   
	"grade":9   
}  
```
### Update place
HTTP Request  
Method: PUT  
Url: {api-base-path}/place  
```json
{  
	"id":2,    
	"name":"Ma place",   
	"description":"Custom description",   
	"grade":   
}  
```
### Find one place

HTTP Request  
Method: GET  
Url: {api-base-path}/place/{place_id}  

Return json content

```json
{  
	"id":,    
	"name":"",   
	"description":"",   
	"grade":   
}  
```


### Find all places

HTTP Request  
Method: GET  
Url: {api-base-path}/places  

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
	"name":"Ma place", //Obligatory field  
	"owner":, //Obligatory field, User id of the roadtrip owner   
	"places":[1,2] //list of places id of a roadtrip  
	"guests":[] //list of roadtrip guests
}  
```
### Update roadtrip
HTTP Request  
Method: PUT  
Url: {api-base-path}/roadtrip  
```json
{  
	"id":, // Roadtrip id   
	"name":"Ma place" // Roadtrip name  
}  
```
If you send json without list of places, only roadtrip name will be updated
or  
```json
{  
	"id":,  
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
	"id":,
	"name":"Ma place", // Roadtrip name  
	"places":[1,2...], //list of places id of a roadtrip  
	"owner"{
		//Json object of user	
	}
}  
```
###Add place to roadtrip

HTTP Request  
Method: POST
url: {api-base-path}/roadtrip/{roadtripId}/place/{placeId}

### Find all roadtrips

May be a not important endpoint, it will probably be replaced  
  
HTTP Request  
Method: GET  
Url: {api-base-path}/roadtrips  

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


#Actions on roadtrips <-> geust
 
###Get roadtrip guests

HTTP Request  
Method: Get  
Url: {api-base-path}/guest/{guestId}/roadtrips  

Return Json array which contains a list of roadtrips  

###Get Roadtrips as guest of user

HTTP Request  
Method: Get  
Url: {api-base-path}/roadtrip/{roadtripId}/guests  

Return json array which contains the guests list

###Add guest to roadtrip

HTTP Request  
Method: PUT  
Url: {api-base-path}/guest/{guestId}/roadTrip/{roadtripId}  


###Remove guest from roadtrip

HTTP Request  
Method: DELETE  
url: {api-base-path}/guest/{guestId}/roadtrip/{roadtripId}  
