1) Aravind sai Thummala

2) 3 and half days (Thursday 6pm to 10pm)
                (Friday 4pm to 6pm)
                (Saturday 11am to 3pm and 8pm to 10pm)
                (Sunday 3pm to 5pm)

3)I have an general idea about how a basic chat application with login and register works:
part A: login, register and list users
  -> I started by creating my database tables and their structure according to design.(In this case 2 tables i.e. users and messages)
  -> Now started with register.php, where new users can create their accounts and this data is saved to database. As part of design request to use OOPs, "User" class was created and
     function/methods were added to it which are related to user objects. register() is the main function here.
  -> After that login.php, where user can provide email and password to enter his account. login() is the method here.
  -> At this point it is easy to list all the users from database, In list_all-users.php the requester will provide an id and the function has to display all the users that
     are registered to use the app excluding requester.
     Now my database has users table accepting new users, allowing existing to login and displaying them.
Part B: send message and list messages
  -> Here I initially created a table named "messages" to store the incoming messages along with sender and receiver data.
  -> Next method is send message for which a new class "Message", send_message() is the function here.
  -> Now the last method view_messages() is implemented by utilizing the provided input id values i.e. sender_id and receiver_id.
Part C:
  -> Validations were handled here:
  -> REQUEST_METHOD Validation (GET or POST)
  -> Request body input empty or not validation
  -> login and register input values validations.(Used validateInput() method for this)
  -> The inputs requester_user_id, sender_user_id, receiver_user_id, user_id_b, user_id_a are validated.
  -> Few other cases handling input ids are validated.(Ex: Same sender and receiver id etc.)

 4) I am not clear about this step. Are you expecting me to host this application in some third party vendors like heroku etc.

 5 and 6)->Clearly using a framework help a lot in improving security and modularity.
         ->Routing and Validation can be added and improved.
         ->May be using MongoDB might help in scaling chat system.
         ->Password can be hashed and stored during registration.
