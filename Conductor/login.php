<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/Conductor.php';
 $database = new Database();
$db = $database->getConnection();
 
// prepare user object
$user = new Conductor($db);

$data = file_get_contents('php://input');
$json = json_decode($data);

$email = $json->{'CON_Email'};
$password = $json->{'CON_Contrasena'};

if(!empty($email) and !empty($password))
{
    $user->CON_Email = $email;
    $user->CON_Contrasena = $password;
    $stmt = $user->login();
    if($stmt->rowCount() > 0){
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // create array
        $user_arr=array(
            "status" => true,
            "message" => "Login Satisfactorio!",
            "ID_Conductor" => $row['ID_Conductor'],
            "CON_Email" => $row['CON_Email']
        );
        http_response_code(200);
    }
    else{
        $user_arr=array(
            "status" => false,
            "message" => "Conductor Incorrecto",
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
