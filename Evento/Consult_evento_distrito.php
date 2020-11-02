<?PHP
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/Evento.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$evento= new Eventos($db);
// set ID property of record to read


$evento->ID_Distrito = isset($_GET['ID_Distrito']) ? $_GET['ID_Distrito'] : die();
  
$stmt = $evento->Consulta_distrito();
$num = $stmt->rowCount();


if($num>0){
  
    // products array
    $evento_arr=array();
    $evento_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
    // create array
    $evento_item = array(
        "ID_Eventos" =>  $ID_Eventos,
        "ID_Distrito" => $ID_Distrito,
        "Distrito" => $Distrito,
        "EVE_Nombres" => $EVE_Nombres,
        "EVE_Descripcion" => $EVE_Descripcion,
        "EVE_Detalles" => $EVE_Detalles,
        "EVE_Fotografia" => $EVE_Fotografia,
        "EVE_Fecha_Hora" => $EVE_Fecha_Hora,
        "EVE_Longitud" => $EVE_Longitud,
        "EVE_Latitud" => $EVE_Latitud
    );
  
  
    // make it json format
    array_push($evento_arr["records"], $evento_item);
}

 http_response_code(200);
  
    // show products data
    echo json_encode($evento_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "Ningun evento encontrado.")
    );
}


?>