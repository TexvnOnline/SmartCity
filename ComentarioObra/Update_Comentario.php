<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate product object
include_once '../objects/Comentario_Obra.php';
  
$database = new Database();
$db = $database->getConnection();
  
$comment = new ComentarioObra($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if( 
    !empty($data->ID_Obra) &&
    !empty($data->COM_Obra) &&
    !empty($data->COM_Calificacion) &&
    !empty($data->ID_Usuario)
){
    $comment->ID_Comentario = $data->ID_Comentario;
  
    // set product property values
    $comment->ID_Obra = $data->ID_Obra;
    $comment->COM_Obra = $data->COM_Obra;
    $comment->COM_Calificacion = $data->COM_Calificacion;
    $comment->ID_Usuario = $data->ID_Usuario;
    // create the product
    if($comment->update()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the obra
        echo json_encode(array("message" => "Comentario actualizado correctamente."));
    }
  
    // if unable to create the product, tell the obra
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the obra
        echo json_encode(array("message" => "Error en la solicitud"));
    }
}
  
// tell the obra data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the obra
    echo json_encode(array("message" => "Error, datos incompletos"));
}
?>