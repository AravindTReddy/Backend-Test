<?php

// include database and object files
include_once 'config/database.php';
include_once 'objects/user.php';
include_once 'objects/message.php';

//request method validation
if($_SERVER["REQUEST_METHOD"] == "POST"){

$database = new Database();
$db = $database->getConnection();

// prepare user and message object
$user = new User($db);
$message = new Message($db);

$data = json_decode(file_get_contents("php://input"));
// set user property values
$message->sender_user_id = $data->sender_user_id;
$message->receiver_user_id = $data->receiver_user_id;
$message->message = isset($data->message) ? $data->message : die();

//validating sender and receiver id
if($user->checkUser($message->sender_user_id)){
    if($user->checkUser($message->receiver_user_id)){
      if($message->send_message()){
          $message_arr=array(
              "success_code" => 200,
              "success_message" => "Message was sent successfully",
              "success_title" => "Message Sent"
          );
      }
    }
}
else{
    $message_arr=array(
      "error_code" => 500,
      "error_title" => "Invalid Id",
      "error_message" => "Sender/requested Id not found, Please try again.",
    );
}
//json encode
print_r(json_encode($message_arr));
}
else {
  $error_arr=array(
      "error_code" => 100,
      "error_title" => "Wrong Request method",
      "error_message" => "I am POST friendly! Sorry GET",
  );
  print_r(json_encode($error_arr));
}
?>
