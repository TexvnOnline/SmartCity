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
include_once '../objects/Parque.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
$parques = new Parques($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if( 
  
    !empty($data->PQ_Nombre) &&
    !empty($data->PQ_Descripcion) &&
    !empty($data->ID_Distrito) &&
    !empty($data->PQ_Direccion) &&
    !empty($data->PQ_Latitud) &&
    !empty($data->PQ_Longitud) 
 
){
  
    // set product property values

    $parques->PQ_Nombre = $data->PQ_Nombre;
    $parques->PQ_Descripcion = $data->PQ_Descripcion;
    $parques->ID_Distrito = $data->ID_Distrito;
    $parques->PQ_Direccion = $data->PQ_Direccion;
    $parques->PQ_Latitud = $data->PQ_Latitud;
    $parques->PQ_Longitud = $data->PQ_Longitud;



    // create the product
    if($parques->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Parque creado correctamente."));
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
