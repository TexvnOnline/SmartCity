<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
// include database and object files
include_once '../config/database.php';
include_once '../objects/Evento.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
$Evento = new Evento($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
			
if( 
    !empty($data->ID_Eventos) &&
    !empty($data->EVE_Nombres) &&
    !empty($data->EVE_Descripcion) &&
    !empty($data->EVE_Detalles) &&
    !empty($data->EVE_Fotografia) &&
    !empty($data->EVE_Fecha_Hora) &&
    !empty($data->EVE_Longitud) &&
    !empty($data->ID_Distrito) &&
    !empty($data->EVE_Latitud)
 
){
  
    // set product property values

    $evento->ID_Eventos = $data->ID_Eventos;
    $evento->EVE_Nombres = $data->EVE_Nombres;
    $evento->EVE_Descripcion = $data->EVE_Descripcion;
    $evento->EVE_Detalles = $data->EVE_Detalles;
    $evento->EVE_Fotografia = $data->EVE_Fotografia;
    $evento->EVE_Fecha_Hora = $data->EVE_Fecha_Hora;
    $evento->EVE_Longitud = $data->EVE_Longitud;
    $evento->ID_Distrito = $data->ID_Distrito;
    $evento->EVE_Latitud = $data->EVE_Latitud;

    // create the product
    if($evento->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Evento creado correctamente."));
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
