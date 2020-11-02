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
include_once '../objects/Incidente.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
$incidente = new Incidente($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if( 
    !empty($data->ID_Vehiculo) &&
    !empty($data->ID_Usuario) &&
    !empty($data->ind_Descripcion) &&
    !empty($data->ind_Fecha_Incidente) &&
    !empty($data->ID_Tipo_Ind) 
 
){
  
    // set product property values

    $incidente->ID_Vehiculo = $data->ID_Vehiculo;
    $incidente->ID_Usuario = $data->ID_Usuario;
    $incidente->ind_Descripcion = $data->ind_Descripcion;
    $incidente->ind_Fecha_Incidente = $data->ind_Fecha_Incidente;
    $incidente->ID_Tipo_Ind = $data->ID_Tipo_Ind;


    // create the product
    if($incidente->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Incidente creado correctamente."));
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
