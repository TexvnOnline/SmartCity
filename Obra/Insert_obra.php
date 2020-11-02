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
include_once '../objects/Obra.php';
  
$database = new Database();
$db = $database->getConnection();
  
$obra = new Obra($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if( 
    !empty($data->OBR_Nombre) &&
    !empty($data->OBR_Descripcion) &&
    !empty($data->ID_Tipo) &&
    !empty($data->OBR_Fecha_Inicio) &&
    !empty($data->OBR_Fecha_Fin) &&
    !empty($data->OBR_Monto) &&
    !empty($data->OBR_Coordenada_X) &&
    !empty($data->OBR_Coordenada_Y) &&
    !empty($data->OBR_Dias_Calendarios)
){
  
    // set product property values
    $obra->OBR_Nombre = $data->OBR_Nombre;
    $obra->OBR_Descripcion = $data->OBR_Descripcion;
    $obra->ID_Tipo = $data->ID_Tipo;
    $obra->OBR_Fecha_Inicio = $data->OBR_Fecha_Inicio;
    $obra->OBR_Fecha_Fin = $data->OBR_Fecha_Fin;
    $obra->OBR_Monto = $data->OBR_Monto;
    $obra->OBR_Coordenada_X = $data->OBR_Coordenada_X;
    $obra->OBR_Coordenada_Y = $data->OBR_Coordenada_Y;
    $obra->OBR_Dias_Calendarios = $data->OBR_Dias_Calendarios;
    // create the product
    if($obra->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the obra
        echo json_encode(array("message" => "Obra creado correctamente."));
    }
  
    // if unable to create the product, tell the obra
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the obra
        echo json_encode(array("message" => "Error en la solicitud"));
    }
}
  
// tell the obra data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the obra
    echo json_encode(array("message" => "Error, datos incompletos"));
}
?>
