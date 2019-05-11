# Backend-Test

In this chat application, users can create an account, login, and send individual messages to other users in the app. 
Below you will see a list of API Endpoints that are implemented.
All API endpoints will json_encode the response data that they send back to the requester.

API Endpoints
Script Name Request
Type

Description Example Request Body Example Response

register.php POST Handles
registering a
brand new user.
{
“email”:”info@datechnologies.co”,
“password”:”Test123”,
“first_name”:”John”,
“last_name”:”Doe”
}

{
“user_id”:1,
“email”:”info@datechnologies.co”,
“first_name”:”John”,
“last_name”:”Doe”
}

login.php POST Handles a login
request from the
user. If the login
was
unsuccessful,
you must send
an appropriate
error response.
{
“email”:”info@datechnologies.co”,
“password”:”Test123”
}

{
“user_id”:1,
“email”:”info@datechnologies.co”,
“first_name”:”John”,
“last_name”:”Doe”
}

view_messages.ph
p

GET Returns all
messages that
these two users
have sent to
each other in
date order.
{
"user_id_a": "1",
"user_id_b": "2"
}

{
"messages":[
{
"message_id":1,
"sender_user_id":1,
"message":"Hey what is up?",
"epoch":1429220026
},
{
"message_id":2,
"sender_user_id":2,
"message":"Not much, how are you
doing?",

"epoch":1429320028
}
]
}

send_message.php POST Sends a
message from
one user to
another. Returns
a success code if
the message
was sent
successfully.
{
“sender_user_id”: 1,
“receiver_user_id”: 2,
“message” : “Example text”
}

{
“success_code” : “200”,
“success_title” : “Message Sent”,
“success_message”: “Message was
sent successfully”
}

list_all_users.php GET Displays all of
the users that
have registered
to use the app
excluding the
requester.
{
“requester_user_id”: 3
}

{
"users":[
{
"user_id":1,
"email":"ppeck@datechnologies.co",
"first_name":"Preston",
"last_name":"Peck"
},
{
"user_id":2,
"email":"jgreen@datechnologies.co",
"first_name":"Jake ",

"last_name":"Green"
}
]
}
