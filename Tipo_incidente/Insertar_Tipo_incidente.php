<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/database.php';

include_once '../objects/Tipo_incidente.php';

$database = new Database();
$db = $database->getConnection();
$tipo_incidente = new Tipo_incidente($db);

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->TIN_Nombre) && 
    !empty($data->TIN_Descripcion)
){

    $tipo_incidente->TIN_Nombre = $data->TIN_Nombre;
    $tipo_incidente->TIN_Descripcion = $data->TIN_Descripcion;

    

    if($tipo_incidente->create()){
        http_response_code(201);
        echo json_encode(array("message" => "sdsd creado correctamente."));
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
