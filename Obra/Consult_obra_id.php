<?PHP
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/Obra.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$obra = new Obra($db);
// set ID property of record to read
$obra->ID_Obra = isset($_GET['ID_Obra']) ? $_GET['ID_Obra'] : die();
  
// read the details of product to be edited
$obra->Consulta_id();  
  
if($obra->ID_Obra!=null){
    // create array
    $obra_arr = array(
        "ID_Obra" =>  $obra->ID_Obra,
        "OBR_Nombre" => $obra->OBR_Nombre,
        "OBR_Descripcion" => $obra->OBR_Descripcion,
        "ID_Tipo" => $obra->ID_Tipo,
        "Tipo_Obra" => $obra->Tipo_Obra,
        "OBR_Fecha_Inicio" => $obra->OBR_Fecha_Inicio,
        "OBR_Fecha_Fin" => $obra->OBR_Fecha_Fin,
        "OBR_Monto" => $obra->OBR_Monto,
        "OBR_Coordenada_X" => $obra->OBR_Coordenada_X,
        "OBR_Coordenada_Y" => $obra->OBR_Coordenada_Y,
        "OBR_Dias_Calendarios" => $obra->OBR_Dias_Calendarios
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($obra_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user product does not exist
    echo json_encode(array("message" => "Obra no existe."));
}


?>