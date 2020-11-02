<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/Lugar_Turistico.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$lugart = new Lugarturistico($db);
  
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));

if( 
	!empty($data->LT_Nombre) &&
    !empty($data->LT_Descripcion) &&
    !empty($data->LT_URL_Map) &&
    !empty($data->ID_Distrito) &&
    !empty($data->LT_Hora_Inicio) &&
    !empty($data->LT_Hora_Fin) && 
    !empty($data->LT_Latitud) &&
    !empty($data->LT_Longitud)
){
	// set ID property of product to be edited
	$lugart->ID_Lugar_Turistico = $data->ID_Lugar_Turistico;
	  
	// set product property values
	$lugart->LT_Nombre = $data->LT_Nombre;
    $lugart->LT_Descripcion = $data->LT_Descripcion;
    $lugart->LT_URL_Map = $data->LT_URL_Map;
    $lugart->ID_Distrito = $data->ID_Distrito;
    $lugart->LT_Hora_Inicio = $data->LT_Hora_Inicio;
    $lugart->LT_Hora_Fin = $data->LT_Hora_Fin;
	$lugart->LT_Latitud = $data->LT_Latitud;
    $lugart->LT_Longitud = $data->LT_Longitud;
	// update the product
	if($lugart->update()){
	  
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
	    echo json_encode(array("message" => "No se pudo actualizar el lugar turistico"));
	}
}else{
	http_response_code(404);
	  
	    // tell the user
	    echo json_encode(array("message" => "Error, datos incompletos"));
}


?>
