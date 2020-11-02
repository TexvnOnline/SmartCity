<?php 
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';

include_once '../objects/Evento.php';
  
$database = new Database();
$db = $database->getConnection();
  
$evento = new Eventos($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
$stmt = $evento->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
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
  
        $evento_item=array(
            "ID_Eventos" => $ID_Eventos,
            "EVE_Nombres" => $EVE_Nombres,
            "EVE_Descripcion" => $EVE_Descripcion,
            "EVE_Detalles" => $EVE_Detalles,
            "EVE_Fotografia" => $EVE_Fotografia,
            "EVE_Fecha_Hora" => $EVE_Fecha_Hora,
            "EVE_Longitud" => $EVE_Longitud,
            "ID_Distrito" => $ID_Distrito,
            "Distrito" => $Distrito,
            "EVE_Latitud" => $EVE_Latitud
        );
  
        array_push($evento_arr["records"], $evento_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show sites data in json format
    echo json_encode($evento_arr);
}
  
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "Eventos no encontrados.")
    );
}
?>