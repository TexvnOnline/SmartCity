<?PHP
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/Evento.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$evento = new Eventos($db);
// set ID property of record to read
$evento->ID_Eventos = isset($_GET['ID_Eventos']) ? $_GET['ID_Eventos'] : die();
  
// read the details of product to be edited
$evento->Consulta_id();  
  
if($evento->ID_Eventos!=null){
    // create array
    $evento_arr = array(
        "ID_Eventos" =>  $evento->ID_Eventos,
        "EVE_Nombres" => $evento->EVE_Nombres,
        "EVE_Descripcion" => $evento->EVE_Descripcion,
        "ID_Distrito" => $evento->ID_Distrito,
        "Distrito" => $evento->Distrito,
        "EVE_Detalles" => $evento->EVE_Detalles,
        "EVE_Fotografia" => $evento->EVE_Fotografia,
        "EVE_Fecha_Hora" => $evento->EVE_Fecha_Hora,
        "EVE_Longitud" => $evento->EVE_Longitud,
        "EVE_Latitud" => $evento->EVE_Latitud
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($evento_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user product does not exist
    echo json_encode(array("message" => "Evento no existe."));
}


?>