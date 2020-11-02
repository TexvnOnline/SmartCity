<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object file
include_once '../config/database.php';
include_once '../objects/Ubicacion.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare  object
$comment = new Ubicacion($db);
  
// get  id
$data = json_decode(file_get_contents("php://input"));
  

$comment->ID_Ubicacion = $data->ID_Ubicacion;
  

if($comment->delete()){
  
  
    http_response_code(200);
  

    echo json_encode(array("message" => "Ubicacion eliminada."));
}
  
// if unable to delete the product
else{
  
   
    http_response_code(503);
  
   
    echo json_encode(array("message" => "No se puede eliminar Ubicacion."));
}
?>