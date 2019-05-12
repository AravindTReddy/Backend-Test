<?php

// include database and object files
include_once 'config/database.php';
include_once 'objects/user.php';
include_once 'objects/message.php';

if($_SERVER["REQUEST_METHOD"] == "GET"){
// get database connection
$database = new Database();
$db = $database->getConnection(); //validate

// prepare user and message object
$user = new User($db);
$message = new Message($db);

$data = json_decode(file_get_contents("php://input"));
// set user property values
// : die();
if(!empty($data)){

$message->user_id_a = $data->user_id_a;
//isset validation
$message->user_id_b = $data->user_id_b;

// User id validation
if($user->checkUser($message->user_id_a) && $user->checkUser($message->user_id_b) && $message->user_id_a != $message->user_id_b){

    $stmt = $message->view_messages($message->user_id_a, $message->user_id_b);
      if($stmt){
        $user_arr=array(
            "messages" => $stmt
        );
      }
      else{
        $user_arr=array(
            "error_code" => 509,
            "error_title" => "MySQL Error",
            "error_message" => "Something wrong, Please try again.",
          );
      }
}
else{
  $user_arr=array(
    "error_code" => 500,
    "error_title" => "Invalid Id",
    "error_message" => "Sender/requested Id not found or Same, Please try again.",
  );
}
}
else {
  $user_arr=array(
      "error_code" => 103,
      "error_title" => "No Data Exception",
      "error_message" => "Please provide me some data and try again.",
  );
  }
}
  else {
    $user_arr=array(
        "error_code" => 500,
        "error_title" => "Wrong Request method",
        "error_message" => "I am GET friendly!",
    );
  }
  print_r(json_encode($user_arr));
  // make it json format
  ?>
