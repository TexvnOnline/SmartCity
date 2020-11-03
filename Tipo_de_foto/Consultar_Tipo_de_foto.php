<?PHP
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/Parque.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$parque = new Parques($db);
// set ID property of record to read
$parque->ID_Parque = isset($_GET['ID_Parque']) ? $_GET['ID_Parque'] : die();
  
// read the details of product to be edited
$parque->Consulta();
  
if($parque->ID_Parque!=null){
    // create array
    $parque_arr = array(
        "ID_Parque" =>  $parque->ID_Parque,
        "PQ_Nombre" => $parque->PQ_Nombre,
        "PQ_Descripcion" => $parque->PQ_Descripcion,
        "ID_Distrito" => $parque->ID_Distrito,
        "Distrito" => $parque->Distrito,
        "PQ_Direccion" => $parque->PQ_Direccion,
        "PQ_Latitud" => $parque->PQ_Latitud,
        "PQ_Longitud" => $parque->PQ_Longitud
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($parque_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user product does not exist
    echo json_encode(array("message" => "Parque no existe."));
}


?>

