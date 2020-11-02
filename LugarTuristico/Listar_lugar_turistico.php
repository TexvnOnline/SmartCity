<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate product object
include_once '../objects/Lugar_Turistico.php';
  
$database = new Database();
$db = $database->getConnection();
  
$lugart = new Lugarturistico($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
$stmt = $lugart->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $lugart_arr=array();
    $lugart_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $lugart_item=array(
            "ID_Lugar_Turistico" => $ID_Lugar_Turistico,
            "LT_Nombre" => $LT_Nombre,
            "LT_Descripcion" => $LT_Descripcion,
            "LT_URL_Map" => $LT_URL_Map,
            "ID_Distrito" => $ID_Distrito,
            "LT_Hora_Inicio" => $LT_Hora_Inicio,
            "LT_Hora_Fin" => $LT_Hora_Fin
        );
  
        array_push($lugart_arr["records"], $lugart_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show sites data in json format
    echo json_encode($lugart_arr);
}
  
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "Lugares no encontrados.")
    );
}
?>
