<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object file
include_once '../config/database.php';
include_once '../objects/Conductor.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare t object
$conductor = new Conductor($db);
  
// get  id
$data = json_decode(file_get_contents("php://input"));
  

$conductor->ID_Conductor = $data->ID_Conductor;
  

if($conductor->delete()){
  
  
    http_response_code(200);
  

    echo json_encode(array("message" => "Conductor fue eliminado."));
}
  

else{
  
   
    http_response_code(503);
  
   
    echo json_encode(array("message" => "No se puede eliminar Conductor."));
}

?>
