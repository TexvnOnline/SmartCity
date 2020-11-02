<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/Ubicacion.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$ubic = new Ubicacion($db);
  
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));

if( 
	!empty($data->ID_Ubicacion) &&
	!empty($data->UB_URL)
){
	// set ID property of product to be edited
	$ubic->ID_Ubicacion = $data->ID_Ubicacion;
	  
	// set product property values
	$ubic->UB_URL = $data->UB_URL;
	$ubic->UB_Via = $data->UB_Via;
	$ubic->UB_Estado = $data->UB_Estado;
	$ubic->UB_Nombre = $data->UB_Nombre;
	$ubic->UB_Longitud = $data->UB_Longitud;
	$ubic->UB_Latitud = $data->UB_Latitud;
	$ubic->UB_ViasAlternas = $data->UB_ViasAlternas;
	// update the product
	if($ubic->update()){
	  
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
	    echo json_encode(array("message" => "No se pudo actualizar el usuario"));
	}
}else{
	http_response_code(404);
	  
	    // tell the user
	    echo json_encode(array("message" => "Error, datos incompletos"));
}


?>
