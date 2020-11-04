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
include_once '../objects/Tipo_de_foto.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
$tipo_de_foto = new Tipo_de_foto($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if( 
  
    !empty($data->TFL_Descripcion) &&
    !empty($data->TFL_Tamano) &&
    !empty($data->TFL_Detalles)
 
){
  
    // set product property values

    $tipo_de_foto->TFL_Descripcion = $data->TFL_Descripcion;
    $tipo_de_foto->TFL_Tamano = $data->TFL_Tamano;
    $tipo_de_foto->TFL_Detalles = $data->TFL_Detalles;



    // create the product
    if($tipo_de_foto->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Tipo_de_foto creado correctamente."));
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
