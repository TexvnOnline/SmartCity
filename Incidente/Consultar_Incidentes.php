<?PHP
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/Incidente.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$incidente = new Incidente($db);
// set ID property of record to read
$incidente->ID_Incidente = isset($_GET['ID_Incidente']) ? $_GET['ID_Incidente'] : die();
  
// read the details of product to be edited
$incidente->Consulta();
  
if($incidente->ID_Incidente!=null){
    // create array
    $incidente_arr = array(
        "ID_Incidente" => $incidente->ID_Incidente,
        "ID_Vehiculo" =>  $incidente->ID_Vehiculo,
        "Placa_Vehiculo" => $incidente->Placa_Vehiculo,
        "ID_Usuario" => $incidente->ID_Usuario,
        "Usuario_Nombres" => $incidente->Usuario_Nombres,
        "ind_Descripcion" => $incidente->ind_Descripcion,
        "ind_Fecha_Incidente" => $incidente->ind_Fecha_Incidente,
        "ID_Tipo_Ind" => $incidente->ID_Tipo_Ind,
        "Tipo_Incidente" => $incidente->Tipo_Incidente
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($incidente_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user product does not exist
    echo json_encode(array("message" => "Incidente no existe."));
}


?>
