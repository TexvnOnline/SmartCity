<?PHP
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/Lugar_Turistico.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$lugar = new Lugarturistico($db);
// set ID property of record to read
$lugar->ID_Lugar_Turistico = isset($_GET['ID_Lugar_Turistico']) ? $_GET['ID_Lugar_Turistico'] : die();
  
// read the details of product to be edited
$lugar->Consulta();
  
if($lugar->ID_Lugar_Turistico!=null){
    // create array
    $lugar_arr = array(
        "ID_Lugar_Turistico" =>  $lugar->ID_Lugar_Turistico,
        "LT_Nombre" => $lugar->LT_Nombre,
        "LT_Descripcion" => $lugar->LT_Descripcion,
        "LT_URL_Map" => $lugar->LT_URL_Map,
        "ID_Distrito" => $lugar->ID_Distrito,
        "Distrito" => $lugar->Distrito,
        "LT_Hora_Inicio" => $lugar->LT_Hora_Inicio,
        "LT_Hora_Fin" => $lugar->LT_Hora_Fin,
      "	LT_Latitud" => $lugar->	LT_Latitud,
      "LT_Longitud" => $lugar->LT_Longitud
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($lugar_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user product does not exist
    echo json_encode(array("message" => "Lugar no existe."));
}


?>
