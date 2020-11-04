<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/Provincia.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$provincia = new Provincia($db);
  
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));

if(  !empty($data->ID_Provincia) &&
    !empty($data->PROV_Nombre) 
){
	// set ID property of product to be edited
	$provincia->ID_Provincia = $data->ID_Provincia;
	  
	// set product property values
	$provincia->PROV_Nombre = $data->PROV_Nombre;
	// update the product
	if($provincia->update()){
	  
	    // set response code - 200 ok
	    http_response_code(200);
	  
	    // tell the user
	    echo json_encode(array("message" => "Datos actualizados correctamente."));
	}
	  
	// if unable to update the product, tell the user
	else{
	  
	    // set response code - 503 service unavailable
	    http_response_code(503);
	  
	    // tell the user
	    echo json_encode(array("message" => "No se pudo actualizar la provincia"));
	}
}else{
	http_response_code(404);
	  
	    // tell the user
	    echo json_encode(array("message" => "Error, datos incompletos"));
}


?>
