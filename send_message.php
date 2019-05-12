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
//input check
//if(!empty($data)){
if(!empty($data->message) && !empty($data->sender_user_id) && !empty($data->receiver_user_id)){
// set user property values
$message->sender_user_id = $data->sender_user_id;
$message->receiver_user_id = $data->receiver_user_id;
$message->message = $data->message;

//validating sender and receiver id
if($user->checkUser($message->sender_user_id) && $user->checkUser($message->receiver_user_id)){
  //echo $message->sender_user_id;
      if($message->sender_user_id != $message->receiver_user_id){
      if($message->send_message()){
          $message_arr=array(
              "success_code" => 200,
              "success_title" => "Message Sent",
              "success_message" => "Message was sent successfully",
          );
      }
      else {
        echo $stmt->errorInfo();
      }
    }
    else {
      $message_arr=array(
          "error_code" => 400,
          "error_title" => "Identical Id",
          "error_message" => "Same id provided, Message was not sent successfully",
      );
    }
}
else{
    $message_arr=array(
      "error_code" => 401,
      "error_title" => "Invalid Id",
      "error_message" => "Sender or requested Id not found, Please try again.",
    );
}
}
else {
  $message_arr=array(
    "error_code" => 103,
    "error_title" => "No Data Exception",
    "error_message" => "Please provide me some data and try again.",
  );
}
}
else {
  $message_arr=array(
      "error_code" => 500,
      "error_title" => "Wrong Request method",
      "error_message" => "I am POST friendly!",
  );
}
//json encode
print_r(json_encode($message_arr));
?>
