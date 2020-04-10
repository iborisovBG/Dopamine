# Dopamine
Rest API

Dopamine

Introduction
Hello , This is a rest API supporting the following Methods POST,
GET,
DELETE,
POST(UPDATE)

Overview
This is Dopamine NEWS api created by Ivaylo Borisov interview task.

Authentication
The Authentication is basic Auth
Admin user :
username : admin password : admin

Normal User:
username: test password: test

Error Codes
code: 2 Not found
code: Not authorized Please contact your APP provider
code: error you have no premissions

Rate limit
There is no rate limits (can be developed easy)

Language
GET GET ALL NEWS 
http://localhost/news/
This is the GET method for all news to use it you need to be logged with basic Auth like administrator or normal user to be able to run this operation.

The executing is very simple you need to use GET method in your query and to call this endpoint example: call the endpoint : http://localhost/news/



Example Request
Default
curl --location --request GET 'http://localhost/news/' \
--data-raw ''
GET GET ONE ID 
http://localhost/news/1
This is the GET method for one news id to use it you need to be logged with basic Auth like administrator or normal user to be able to run this operation.

The executing is very simple you need to use GET method in your query and to call this endpoint example: call the endpoint : http://localhost/news/{id}



Example Request
GET ONE ID
curl --location --request GET 'http://localhost/news/1'
POST POST (INSERT) 
http://localhost/news/
This is the POST method to use it you need to be logged with basic Auth like administrator to be able to run this operation.

The executing is very simple you need to use POST method in your query and to call this endpoint example: call the endpoint : http://localhost/news/ To make INSERT of news id use the following code in body(raw) if you use postman.

BODY raw
{
"title" : "This is title",
"date": "2020.04.10 14:55",
"text": "this is text"
}


Example Request
POST (INSERT)
curl --location --request POST 'http://localhost/news/' \
--data-raw '{
"title" : "This is title",
"date": "2020.04.10 14:55",
"text": "this is text"
}'
POST POST (UPDATE) 
http://localhost/news/31
This is the UPDATE method to use it you need to be logged with basic Auth like administrator to be able to run this operation.

The executing is very simple you need to use POST method in your query and to call this endpoint example: call the endpoint : http://localhost/news/{id} and use the following data to UPDATE the record id.

BODY raw
{
"title" : "This is 22",
"date": "2020.04.10 14:55",
"text": "this is text 2222"
}


Example Request
POST (UPDATE)
curl --location --request POST 'http://localhost/news/31' \
--data-raw '{
"title" : "This is 22",
"date": "2020.04.10 14:55",
"text": "this is text 2222"
}'
DEL DELETE 
http://localhost/news/31
This is the delete method to use it you need to be logged with basic Auth like administrator to be able to run this operation.

The executing is very simple you need to use DELETE method in your query and to call this endpoint example: http://localhost/news/{id}



Example Request
DELETE
curl --location --request DELETE 'http://localhost/news/31'
GET GET Comments 
http://localhost/news/1/users/1/comments/1
This is the GET method for comments writed to news to use it you need to be logged with basic Auth like administrator or normal user to be able to run this operation.

The executing is very simple you need to use GET method in your query and to call this endpoint example: call the endpoint : http://localhost/news/{id}/users/{id}/comments/{id}
