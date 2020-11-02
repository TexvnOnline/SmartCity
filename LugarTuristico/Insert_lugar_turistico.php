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
include_once '../objects/Lugar_Turistico.php';
  
$database = new Database();
$db = $database->getConnection();
  
$lugart = new Lugarturistico($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if( 
    !empty($data->LT_Nombre) &&
    !empty($data->LT_Descripcion) &&
    !empty($data->LT_URL_Map) &&
    !empty($data->ID_Distrito) &&
    !empty($data->LT_Hora_Inicio) &&
    !empty($data->LT_Hora_Fin) &&
    !empty($data->LT_Latitud) &&
    !empty($data->LT_Longitud)
){
  
    // set product property values
    $lugart->LT_Nombre = $data->LT_Nombre;
    $lugart->LT_Descripcion = $data->LT_Descripcion;
    $lugart->LT_URL_Map = $data->LT_URL_Map;
    $lugart->ID_Distrito = $data->ID_Distrito;
    $lugart->LT_Hora_Inicio = $data->LT_Hora_Inicio;
    $lugart->LT_Hora_Fin = $data->LT_Hora_Fin;
      $lugart->LT_Latitud = $data->LT_Latitud;
    $lugart->LT_Longitud = $data->LT_Longitud;
  
    // create the product
    if($lugart->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the lugart
        echo json_encode(array("message" => "Lugar turistico creado correctamente."));
    }
  
    // if unable to create the product, tell the lugart
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the lugart
        echo json_encode(array("message" => "Error en la solicitud"));
    }
}
  
// tell the lugart data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the lugart
    echo json_encode(array("message" => "Error, datos incompletos"));
}
?>
