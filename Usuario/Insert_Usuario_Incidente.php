<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate product object
include_once '../objects/usuario.php';
  
$database = new Database();
$db = $database->getConnection();
  
$user = new Usuario($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if( 
    !empty($data->US_Nombres) &&
    !empty($data->US_Apellidos) &&
    !empty($data->US_Email) &&
    !empty($data->US_Contrasena) 
){
  
    // set product property values
    $user->US_Nombres = $data->US_Nombres;
    $user->US_Apellidos = $data->US_Apellidos;
    $user->US_Email = $data->US_Email;
    $user->US_Contrasena = $data->US_Contrasena;
    // create the product
    if($user->createIncidente()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Usuario creado correctamente."));
    }
  
    // if unable to create the product, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Error en la solicitud"));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Error, datos incompletos"));
}
?>