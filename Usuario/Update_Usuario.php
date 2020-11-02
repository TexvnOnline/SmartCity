<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/usuario.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$user = new Usuario($db);
  
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));

if( 
	!empty($data->ID_Usuario)
){
	// set ID property of product to be edited
	$user->ID_Usuario = $data->ID_Usuario;
	  
	// set product property values
	$user->US_Nombres = $data->US_Nombres;
	$user->US_Apellidos = $data->US_Apellidos;
	$user->US_Direccion = $data->US_Direccion;
	$user->US_Fecha_Nacimiento = $data->US_Fecha_Nacimiento;
	$user->US_Nacionalidad = $data->US_Nacionalidad;
	$user->US_Telefono = $data->US_Telefono;
	$user->US_Email = $data->US_Email;
	// update the product
	if($user->update()){
	  
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