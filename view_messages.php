<?php

session_start();
// include database and object files
include_once 'config/database.php';
include_once 'objects/user.php';
include_once 'objects/message.php';

// get database connection
$database = new Database();
$db = $database->getConnection(); //validate

// prepare user and message object
$user = new User($db);
$message = new Message($db);

$data = json_decode(file_get_contents("php://input"));
// set user property values
//$user->username = $_GET['username']) ? $_GET['username'] : die();
$message->user_id_a = isset($data->user_id_a) ? $data->user_id_a : die();
//isset validation
$message->user_id_b = $data->user_id_b;

// User id validation
if($user->checkUser($message->user_id_a)){
    if($user->checkUser($message->user_id_b)){
      $stmt = $message->view_messages($message->user_id_a, $message->user_id_b);
    }
    else{

    }
  }
  else{}
    // get retrieved row
if($stmt){
  $user_arr=array(
      "messages" => $stmt
  );
}
else{
  $user_arr=array(
      "status" => false,
      "message" => "Oopssss!",
  );

}
print_r(json_encode($user_arr));
// make it json format


?>
