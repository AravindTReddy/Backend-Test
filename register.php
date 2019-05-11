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

// set user property values
$user->first_name = $data->first_name;
$user->last_name = $data->last_name;
$user->email = $data->email;
$user->password = $data->password;
// create the user
if($user->register()){
    $user_arr=array(
        "id" => $user->id,
        "email" => $user->email,
        "first_name" =>$user->first_name,
        "last_name" => $user->last_name
    );
}
else{
    $user_arr=array(
      "error_code" => 102,
      "error_title" => "Registration Failed",
      "error_message" => "Entered email already exists",
    );
}
// make it json format
print_r(json_encode($user_arr));
}
else {
  $error_arr=array(
      "error_code" => 500,
      "error_title" => "Wrong Request method",
      "error_message" => "I am POST friendly! Sorry GET",
  );
  print_r(json_encode($error_arr));
}
?>
