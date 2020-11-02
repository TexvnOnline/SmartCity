<?PHP
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/Conductor.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare Conductor object
$conductor = new Conductor($db);
$data = file_get_contents('php://input');
$json = json_decode($data);


  
// read the details of product to be edited
$ID_Conductor = $json->{'ID_Conductor'};

if(!empty($ID_Conductor)){
    // create array
    $conductor->ID_Conductor =$ID_Conductor;
    $stmt = $conductor->Consulta();
    
    if($stmt->rowCount() > 0){  
     $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // create array
        $user_arr=array(
            "status" => true,
            "ID_Conductor" => $row['ID_Conductor'],
            "CON_Nombre" => $row['CON_Nombre'],
            "CON_Apellidos" => $row['CON_Apellidos'],
            "CON_Telefono" => $row['CON_Telefono'],
            "CON_Direccion" => $row['CON_Direccion'],
            "CON_Licencia" => $row['CON_Licencia'],
            "CON_Latitud" => $row['CON_Latitud'],
            "CON_Longitud" => $row['CON_Longitud'],
            "CON_FCM" => $row['CON_FCM'],
            "CON_Fotografia_Licencia" => $row['CON_Fotografia_Licencia'],
            "CON_Email" => $row['CON_Email']
    );
  
    // set response code - 200 OK
    http_response_code(200);
  }else{
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
