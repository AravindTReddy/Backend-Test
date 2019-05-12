<?php

// include database and object files
include_once 'config/database.php';
include_once 'objects/user.php';
//post method validation
if($_SERVER["REQUEST_METHOD"] == "POST"){

// get database connection
$database = new Database();
$db = $database->getConnection();

// instantiate user object
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data)){

$valid = $user->validateInput($data->first_name, $data->last_name, $data->email, $data->password );
// set user property values
$user->first_name = trim($data->first_name);
$user->last_name = trim($data->last_name);
$user->email = trim($data->email);
$user->password = trim($data->password);

if(empty($valid)){
// create the user
$register  = $user->register();
if($register === 200){
    $user_arr=array(
        "id" => $user->id,
        "email" => $user->email,
        "first_name" =>$user->first_name,
        "last_name" => $user->last_name
    );
}
else if ($register == 101){
  $user_arr=array(
    "error_code" => 202,
    "error_title" => "Registration Failed",
    "error_message" => "Email-id already exist.",
  );
}
else{
    $user_arr=array(
      "error_code" => 204,
      "error_title" => "Registration Failed",
      "error_message" => "Something went wrong",
    );
}
}
else {
  $user_arr=array(
      "error_code" => 203,
      "error_title" => "Registration Failed",
      "error_message" => $valid,
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
      "error_message" => "I am POST friendly! Sorry GET",
  );
}
// make it json format
print_r(json_encode($user_arr));
?>
