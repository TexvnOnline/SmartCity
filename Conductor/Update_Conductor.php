<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/Conductor.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$conductor = new Conductor($db);
  
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));

if( 
	!empty($data->ID_Conductor)
){
	// set ID property of product to be edited
	$conductor->ID_Conductor = $data->ID_Conductor;
	  
	// set product property values
	$conductor->CON_Nombre = $data->CON_Nombre;
	$conductor->CON_Apellidos = $data->CON_Apellidos;
	$conductor->CON_Telefono = $data->CON_Telefono;
	$conductor->CON_Direccion = $data->CON_Direccion;
	$conductor->CON_Licencia = $data->CON_Licencia;
	$conductor->ID_Empresa_Transp = $data->ID_Empresa_Transp;
	$conductor->CON_Latitud = $data->CON_Latitud;
	$conductor->CON_Longitud = $data->CON_Longitud;
	$conductor->CON_Status = $data->CON_Status;
	$conductor->CON_FCM = $data->CON_FCM;
	$conductor->CON_Fotografia_Licencia = $data->CON_Fotografia_Licencia;
	$conductor->CON_Email = $data->CON_Email;
	// update the product
	if($conductor->update()){
	  
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
	    echo json_encode(array("message" => "No se pudo actualizar el conductor"));
	}
}else{
	http_response_code(404);
	  
	    // tell the user
	    echo json_encode(array("message" => "Error, datos incompletos"));
}


?>
