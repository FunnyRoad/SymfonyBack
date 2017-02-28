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

* Pictures
  * Description of picture backend object
  * Add picture to place
  * Get pictures Ids of place
  * Get picture
  * Delete picture

#User

### Create user

HTTP Request  
Method: POST  
Url: {api-base-path}/user
```json
{  
	"mail":"mail address", //obligatory  
	"firebaseId":"", //obligatory  	  
	"city":"",  
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
	"city":"",  
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
	"city":"",  
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
	"city":"",  
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
 	"latitude":,// Obligatory field  
	"longitude":,// Obligatory field  
	"description":"",   
	"grade":9,   
	"type":""  
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
	"grade":,  
 	"latitude":,  
	"longitude":,  
	"type":"",     
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
	"grade":,  
 	"latitude":,  
	"longitude":,  
	"type":""  
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
	"departure":"",  
	"arrival":"",  	
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
	"departure":"",  
	"arrival":"",  	
}  
```
If you send json without list of places, only roadtrip name will be updated
or  
```json
{  
	"id":,  
	"name":"Ma place", // Roadtrip name  
	"departure":"",  
	"arrival":"",  	
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
	"departure":"",  
	"arrival":"",  	
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

return json array which contains list of roadtrips (same format as find all places)  

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


#Picture

###Description of picture backend object
Actually, a picture is necessary in relation with one place. Picture is described by two fields an "id" and a "type".  
* The picture type: jpg, png... you will never have to send this informations but you can get it.
* The id is automatically generated by the database.
* The picture name is concatenation of id.type
  
For the following, when we speak about picture we don't speak about the entity but about an real picture. The previous text have like goal just to explain the backend working 

###Add picture to place
HTTP Request   
Method POST  
Url: {api-base-path}/place/{placeId}/picture  
   
the body content must be a picture with a key "picture"   


### Get pictures of place
HTTP Request   
Method Get  
Url: {api-base-path}place/{place}/pictures  

Returns json array which contain list of pictures entities  
```json  
[{  
	"id":,  
	"type":""  
}]  
```

### Get picture
HTTP Request  
Method Get  
Url: {api-base-path}/picture/{picture}  

the reques will return a picture

### Delete picture
HTTP Request  
Method Delete  
url: {api-base-path}/picture/{picture}  

