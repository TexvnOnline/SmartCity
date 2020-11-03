<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/database.php';

include_once '../objects/Provincia.php';

$database = new Database();
$db = $database->getConnection();
$tipo_incidente = new Provincia($db);

$data = json_decode(file_get_contents("php://input"));

if(
    
    !empty($data->PROV_Nombre)
){

    $tipo_incidente->PROV_Nombre = $data->PROV_Nombre;

    

    if($tipo_incidente->create()){
        http_response_code(201);
        echo json_encode(array("message" => "Provincia creada correctamente."));
    }
    else{
        http_response_code(503);
        echo json_encode(array("message" => "Error en la solicitud"));
    }
}
else{
    http_response_code(400);
    echo json_encode(array("message" => "Error, datos incompletos"));
}
?>
