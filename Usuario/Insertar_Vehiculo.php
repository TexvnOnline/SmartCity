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
include_once '../objects/Vehiculo.php';
  
$database = new Database();
$db = $database->getConnection();
  
$vehiculo = new Vehiculo($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if( 
  
    !empty($data->VEH_Placa) &&
    !empty($data->VEH_Color) &&
    !empty($data->VEH_Modelo) &&
    !empty($data->VEH_Marca) &&
    !empty($data->ID_Tipo_Vehiculo) &&
    !empty($data->ID_Conductor)
 
){
  
    // set product property values

    $user->VEH_Placa = $data->VEH_Placa;
    $user->VEH_Color = $data->VEH_Color;
    $user->VEH_Modelo = $data->VEH_Modelo;
    $user->VEH_Marca = $data->VEH_Marca;
    $user->ID_Tipo_Vehiculo = $data->ID_Tipo_Vehiculo;
    $user->ID_Conductor = $data->ID_Conductor;

    // create the product
    if($user->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Vehiculo creado correctamente."));
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