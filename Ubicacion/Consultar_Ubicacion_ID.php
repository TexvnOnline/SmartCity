<?PHP
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/Ubicacion.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$ubicacion = new Ubicacion($db);
// set ID property of record to read
$ubicacion->ID_Ubicacion = isset($_GET['ID_Ubicacion']) ? $_GET['ID_Ubicacion'] : die();
  
// read the details of product to be edited
$ubicacion->Consulta();
  
if($ubicacion->ID_Ubicacion!=null){
    // create array
    $ubicacion_arr = array(
        "ID_Ubicacion" =>  $ubicacion->ID_Ubicacion,
        "UB_URL" => $ubicacion->UB_URL,
        "UB_Via" => $ubicacion->UB_Via,
        "UB_Estado" => $ubicacion->UB_Estado,
        "UB_Nombre" => $ubicacion->UB_Nombre,
        "UB_Longitud" => $ubicacion->UB_Longitud,
        "UB_Latitud" => $ubicacion->UB_Latitud,
        "UB_ViasAlternas" => $ubicacion->UB_ViasAlternas
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($ubicacion_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user product does not exist
    echo json_encode(array("message" => "Ubicacion no existe."));
}


?>
