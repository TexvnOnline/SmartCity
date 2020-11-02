<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/usuario.php';
 $database = new Database();
$db = $database->getConnection();
 
// prepare user object
$user = new Usuario($db);

$data = file_get_contents('php://input');
$json = json_decode($data);

 
// read the details of product to be edited
$ID_Usuario = $json->{'ID_Usuario'};
  
if(!empty($ID_Usuario))
{
    $user->ID_Usuario = $ID_Usuario;
    $stmt = $user->ConsultaID();
    // create array
   
    if($stmt->rowCount() > 0){  
     $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // create array
        $user_arr=array(
            "status" => true,
            "message" => "Consulta Satisfactoria!",
            "ID_Usuario" => $row['US_Nombres'],
            "US_Nombres" => $row['US_Nombres'],
            "US_Apellidos" => $row['US_Apellidos'],
            "US_Direccion" => $row['US_Direccion'],
            "US_Fecha_Nacimiento" => $row['US_Fecha_Nacimiento'],
            "US_Nacionalidad" => $row['US_Nacionalidad'],
            "US_Telefono" => $row['US_Telefono'],
            "US_Email" => $row['US_Email']
    );
  
    // set response code - 200 OK
    http_response_code(200);
  }else{
        $user_arr=array(
            "status" => false,
            "message" => "Usuario Incorrecto",
        );
        http_response_code(404);
        
    }
}

else
{
    $user_arr=array(
            "status" => false,
            "message" => "Datos Incompletos",
        );
    http_response_code(500);
}
echo json_encode($user_arr);

?>