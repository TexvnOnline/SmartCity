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
include_once '../objects/Recursos_Cercanos.php';
  
$database = new Database();
$db = $database->getConnection();
  
$user = new Recursos_Cercanos($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if( 
    !empty($data->RES_Nombre) &&
    !empty($data->RES_Descripcion) &&
    !empty($data->RES_Tipo) &&
    !empty($data->RES_Hora_Atencion) &&
    !empty($data->RES_URL_Map) &&
    !empty($data->RES_Pagina_Web) &&
    !empty($data->RES_Telefono) &&
    !empty($data->RES_Facebook)
){
  
    // set product property values
    $user->RES_Nombre = $data->RES_Nombre;
    $user->RES_Descripcion = $data->RES_Descripcion;
    $user->RES_Tipo = $data->RES_Tipo;
    $user->RES_Hora_Atencion = $data->RES_Hora_Atencion;
    $user->RES_URL_Map = $data->RES_URL_Map;
    $user->RES_Pagina_Web = $data->RES_Pagina_Web;
    $user->RES_Telefono = $data->RES_Telefono;
    $user->RES_Facebook = $data->RES_Facebook;
    // create the product
    if($user->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Recurso Cercano creado correctamente."));
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