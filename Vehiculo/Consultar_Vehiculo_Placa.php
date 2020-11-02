<?PHP
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/Vehiculo.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$vehiculo = new Vehiculo($db);
// set ID property of record to read
$vehiculo->VEH_Placa = isset($_GET['VEH_Placa']) ? $_GET['VEH_Placa'] : die();
  
// read the details of product to be edited
$vehiculo->Consulta();
  
if($vehiculo->VEH_Placa!=null){
    // create array
    $vehiculo_arr = array(
        "ID_Vehiculo" =>  $vehiculo->ID_Vehiculo,
        "VEH_Placa" => $vehiculo->VEH_Placa,
        "VEH_Color" => $vehiculo->VEH_Color,
        "VEH_Modelo" => $vehiculo->VEH_Modelo,
        "VEH_Marca" => $vehiculo->VEH_Marca,
        "ID_Tipo_Vehiculo" => $vehiculo->ID_Tipo_Vehiculo,
        "Tipo_Vehiculo" => $vehiculo->Tipo_Vehiculo,
        "ID_Conductor" => $vehiculo->ID_Conductor,
        "Nombre_Conductor" => $vehiculo->Nombre_Conductor
  
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($vehiculo_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user product does not exist
    echo json_encode(array("message" => "Vehiculo no existe."));
}


?>