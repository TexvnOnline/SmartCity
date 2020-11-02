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
include_once '../objects/Ubicacion.php';
  
$database = new Database();
$db = $database->getConnection();
  
$ubicacion = new Ubicacion($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if( 
    !empty($data->UB_URL) &&
    !empty($data->UB_Via) &&
    !empty($data->UB_Estado) &&
    !empty($data->UB_Nombre) &&
    !empty($data->UB_Longitud) &&
    !empty($data->UB_Latitud) &&
    !empty($data->UB_ViasAlternas)
){
  
    // set product property values
    $ubicacion->UB_URL = $data->UB_URL;
    $ubicacion->UB_Via = $data->UB_Via;
    $ubicacion->UB_Estado = $data->UB_Estado;
    $ubicacion->UB_Nombre = $data->UB_Nombre;
    $ubicacion->UB_Longitud = $data->UB_Longitud;
    $ubicacion->UB_Latitud = $data->UB_Latitud;
    $ubicacion->UB_ViasAlternas = $data->UB_ViasAlternas;
    // create the product
    if($ubicacion->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the ubicacion
        echo json_encode(array("message" => "Ubicacion creada correctamente."));
    }
  
    // if unable to create the product, tell the ubicacion
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the ubicacion
        echo json_encode(array("message" => "Error en la solicitud"));
    }
}
  
// tell the ubicacion data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the ubicacion
    echo json_encode(array("message" => "Error, datos incompletos"));
}
?>
