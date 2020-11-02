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
include_once '../objects/Conductor.php';
  
$database = new Database();
$db = $database->getConnection();
  
$conductor = new Conductor($db);

 if(is_uploaded_file($_FILES["conductor_image"]["tmp_name"])){
     $tmp_file = $_FILES["conductor_image"]["tmp_name"];
     $img_name = $_FILES["conductor_image"]["name"];
     $upload_dir = "../images/".$img_name;
     $conductor->CON_Fotografia_Licencia = $upload_dir;
 }
  
// make sure data is not empty
if( 
    !empty($_POST["CON_Nombre"]) &&
    !empty($_POST["CON_Apellidos"]) &&
    !empty($_POST["CON_Telefono"]) &&
    !empty($_POST["CON_Direccion"]) &&
    !empty($_POST["CON_Licencia"]) &&
    !empty($_POST["ID_Empresa_Transp"]) &&
    !empty($_POST["CON_Latitud"]) &&
    !empty($_POST["CON_Longitud"]) &&
    !empty($_POST["CON_Status"]) &&
    !empty($_POST["CON_FCM"]) &&
    !empty($_POST["CON_Email"]) &&
    !empty($_POST["CON_Contrasena"])
)
    {
  
    // set product property values
    $conductor->CON_Nombre = $_POST["CON_Nombre"];
    $conductor->CON_Apellidos = $_POST["CON_Apellidos"];
    $conductor->CON_Telefono = $_POST["CON_Telefono"];
    $conductor->CON_Direccion = $_POST["CON_Direccion"];
    $conductor->CON_Licencia = $_POST["CON_Licencia"];
    $conductor->ID_Empresa_Transp = $_POST["ID_Empresa_Transp"];
    $conductor->CON_Latitud = $_POST["CON_Latitud"];
    $conductor->CON_Longitud = $_POST["CON_Longitud"];
    $conductor->CON_Status = $_POST["CON_Status"];
    $conductor->CON_FCM = $_POST["CON_FCM"];
    $conductor->CON_Email = $_POST["CON_Email"];
    $conductor->CON_Contrasena = $_POST["CON_Contrasena"];
    // create the product
    if($conductor->create() && move_uploaded_file($tmp_file, $upload_dir)){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the obra
        echo json_encode(array("message" => "Conductor creado correctamente.","status" => "Imagen subida"));
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
