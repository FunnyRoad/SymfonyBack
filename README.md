#API Documentation 
The following API will permise you to manage roadsTrips using FunnyRoad application.

# Install project (for developpers)
You need to install mysq, clone the project and execute the command: composer install  
You will have to provide database informations since the execution of composer install  
Finally, create databae named funnyroad and all is ok.
execute "bin/console server:run" and your api will be ready to use.

## API Links
api-base-path:  
* dev : localhost:8000  
* preprod : vps376653.ovh.net:8080    

## Api summary:

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
  * Find list places by ids
  * Delete place
  * Find nearest Places
  * Find place by name
  * Find place by google id
  * Add rate to place
  
* Entity RoadTrip 
  * Create roadtrip
  * Update roadtrip
  * Find roadtrip
  * Find all roadtrips
  * Find places of roadtrip
  * Delete roadtrip
  * Delete one place from a roadtrip
  * Find nearest Roadtrips

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
  * Add picture to post
  * Get pictures id of post
  * Get picture of post 
  * Delete picture


* Roadtrip followers <-> User followed roadtrips
  * Add follower to roadtrip
  * Get followed roadtrips
  * Get roadtrip followers
  * Remove roadtrip follower

* Post
  * Get roadtrip posts
  * Find post
  * Find all posts
  * Create and add post to roadtrip
  * Update post
  * Delete post 

# User

### Get roadtrip posts
HTTP Request
Method: Get
Url: {api-base-path}/roadtrip/{roadtrip}/posts

return lis of posts

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
### Find user
HTTP Request
Method: GET
Url: {api-base-path}/user/{id}

Return json object of the found user
 
### Delete user

HTTP Request
Method: GET
Url: {api-base-path}/user/{id}


### Update user 

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
}4
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
	"type":"",  
	"googleId":""  	
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
	"googleId":""  
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
	"type":"",  
	"googleId":""    
}  
```


### Find all places

HTTP Request  
Method: GET  
Url: {api-base-path}/places  

Return Json array with list of places

### Find list places by ids
HTTP Request
Method: POST
Url: {api-base-path}/places
```json
{    
    "placesId":[1,2] //list places id	  
}  
```

### Delete place
HTTP Request  
Method: DELETE  
Url: {api-base-path}/place/{place_id}  

### Find nearest places
HTTP Request
Method: GET
url: {api-base-path}/place/nearest/{latitude}/{longitude}/{distance}

You can give the max distance you want for search (in km), by defaul, the distance is 50km

### Find place by name
HTTP Request  
Method: Get  
Url: {api-base-path}/place/name/{name}

Return json object of place

### Find place by googleId
HTTP Request  
Method: Get  
Url: {api-base-path}/place/googleId/{googleId}  

Return json object of place  

### 

# RoadTrip
HTTP Request  
Method: Post  
Url: /place/{placeId}/rate/{rate}  

returns place withe the updated rate  

### Create Roadtrip
HTTP Request  
Method: POST  
Url: {api-base-path}/roadtrip
```json
{  
	"name":"Mon roadtrip", //Obligatory field  
	"owner":, //Obligatory field, User id of the roadtrip owner   
	"departure":{  
		"googleId":"", //not obligatory
		"latitude":82,//obligatory           
   		"longitude":64//obligatory  
	},//obligatory  
	"arrival":"",//obligatory  
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
	"name":"Roadtrip name", // Roadtrip name  
	"departure":{  
		"googleId":"",
		"latitude":82,           
   		"longitude":64  
	},  	
	"arrival":"" 	
}  
```
If you send json without list of places, only roadtrip name will be updated
or  
```json
{  
	"id":,  
	"name":"Roadtrip Name", // Roadtrip name  
	"departure":{  
		"googleId":"", //not obligatory
		"latitude":82,           
   		"longitude":64  
	},  
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
	"name":"Roadtrip name", // Roadtrip name  
	"places":[1,2...], //list of places id of a roadtrip  
	"departure":{  
		"googleId":"", //not obligatory
		"latitude":82,           
   		"longitude":64  
	},
	"arrival":"",  	
	"owner"{
		//Json object of user	
	}
}  
```
### Add place to roadtrip

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


### Find nearest roadtrips
HTTP Request
Method: GET
url: {api-base-path}/roadtrip/user/{userId}/nearest/{latitude}/{longitude}/{distance}

You can give the max distance you want for search (in km), by defaul, the distance is 50km

# Actions on roadtrips <-> geust
 
### Get roadtrip guests

HTTP Request  
Method: Get  
Url: {api-base-path}/guest/{userId}/roadtrips  

Return Json array which contains a list of roadtrips  

### Get Roadtrips as guest of user

HTTP Request  
Method: Get  
Url: {api-base-path}/roadtrip/{roadtripId}/guests  

Return json array which contains the guests list

### Add guest to roadtrip

HTTP Request  
Method: PUT  
Url: {api-base-path}/guest/{userId}/roadTrip/{roadtripId}  
	

### Remove guest from roadtrip

HTTP Request  
Method: DELETE  
url: {api-base-path}/guest/{userId}/roadtrip/{roadtripId}  


# Picture

### Description of picture backend object
Actually, a picture is necessary in relation with one place. Picture is described by two fields an "id" and a "type".  
* The picture type: jpg, png... you will never have to send this informations but you can get it.
* The id is automatically generated by the database.
* The picture name is concatenation of id.type
  
For the following, when we speak about picture we don't speak about the entity but about an real picture. The previous text have like goal just to explain the backend working 

### Add picture to place
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
Url: {api-base-path}/picture/{pictureId}  

the reques will return a picture


### Add picture to post
HTTP Request  
Method: Post  
Url: {api-base-path}/post/{postId}/picture  

the body content must be a picture with a key "picture"   

### Get pictures id of post
HTTP Request
Method: Get
Url: {api-base-path}/post/{post}/pictures

Returns json array which contain list of pictures entities  
```json  
[{  
	"id":,  
	"type":""  
}]  
```


### Get picture of post 
HTTP Request  
Method: Get  
Url: {api-base-path}/post/picture/{pictureId}

Return a picture (an image: jpg, png ...)
 

### Delete picture
HTTP Request  
Method Delete  
url: {api-base-path}/picture/{picture}  


# Roadtrip followers <-> User followed roadtrips

### Add follower to roadtrip

HTTP Request  
Method: put  
Url: {api-base-path}/follower/{userId}/roadtrip/{roadtripId}  

return json:
```json
{  
	"success":"Follower have been added"  
}  
```
### Get followed roadtrips

HTTP Request  
Method: Get  
Url: {api-base-path}/follower/{userId}/roadtrips  

Return json array which contains the list of followed roadtrips

### Get roadtrip followers

HTTP Request  
Method: Get  
Url: {api-base-path}/roadtrip/{roadtripId}/followers  
	
return json array which contains the list of roadtrip followers (list of Users)

### Remove roadtrip follower

HTTP Request  
Method: DELETE  
url: {api-base-path}/follower/{userId}/roadtrip/{roadtripId}  

```json
{  
	"success":"Follower have been removed"  
}  
```


# Post
### Find post
HTTP Request
Method: Get
Url: {api-base-path}/post/{id}

return json object like below
```json
{  
    "id":1,  
    "text":"hey ",  
    "roadtripId":1,  
    "picturesId":[7,8]  
}  
```

### Find all posts
HTTP Request
Method: Get
Url: {api-base-path}/posts

returns json array of posts
### Create and add post to roadtrip
HTTP Request
Method: Post
Url; {api-base-path}/post/{postId}

```json
{  
	"text":"hey aujourd'hui il fait vraiment beau", //Obligatory  
	"roadtripId": //Obligatory  
}
```

### Update post
HTTP Request
Method: Put
Url; {api-base-path}/post/{postId}

```json
{  
	"text":"hey aujourd'hui il fait vraiment beau", //Obligatory  
	"roadtripId": //Obligatory  
}
```



### Delete post
HTTP Request
Method: Delete
Url; {api-base-path}/post/{postId}

