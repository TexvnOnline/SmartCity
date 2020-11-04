<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/Tipo_incidente.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$tipo_incidente = new Tipo_incidente($db);
  
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));

if(  !empty($data->ID_Tipo_Ind) &&
    !empty($data->TIN_Nombre) &&
    !empty($data->TIN_Descripcion) 
){
	// set ID property of product to be edited
	$tipo_incidente->ID_Tipo_Ind = $data->ID_Tipo_Ind;
	  
	// set product property values
	$tipo_incidente->TIN_Nombre = $data->TIN_Nombre;
    $tipo_incidente->TIN_Descripcion = $data->TIN_Descripcion;
	// update the product
	if($tipo_incidente->update()){
	  
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
	    echo json_encode(array("message" => "No se pudo actualizar el tipo de indicente"));
	}
}else{
	http_response_code(404);
	  
	    // tell the user
	    echo json_encode(array("message" => "Error, datos incompletos"));
}


?>
