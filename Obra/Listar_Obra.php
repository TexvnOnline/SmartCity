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
include_once '../objects/Obra.php';
  
$database = new Database();
$db = $database->getConnection();
  
$obra = new Obra($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
$stmt = $obra->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $obra_arr=array();
    $obra_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $obra_item=array(
            "ID_Obra" => $ID_Obra,
            "OBR_Nombre" => $OBR_Nombre,
            "OBR_Descripcion" => $OBR_Descripcion,
            // "ID_Tipo" => $EVE_Detalles,
            // "Tipo_Obra" => $EVE_Fotografia,
            "OBR_Fecha_Inicio" => $OBR_Fecha_Inicio,
            "OBR_Fecha_Fin" => $OBR_Fecha_Fin,
            "OBR_Monto" => $OBR_Monto,
            "OBR_Coordenada_X" => $OBR_Coordenada_X,
            "OBR_Coordenada_Y" => $OBR_Coordenada_Y,
            "OBR_Dias_Calendarios" => $OBR_Dias_Calendarios,
            "Encargado_Nombre" => $Encargado_Nombre,
            "Encargado_Apellidos" => $Encargado_Apellidos,
            "Encargado_Cargo" => $Encargado_Cargo,
            "Obra_Fotografia" => $Obra_Fotografia
        );
  
        array_push($obra_arr["records"], $obra_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show sites data in json format
    echo json_encode($obra_arr);
}
  
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "Obras no encontradas.")
    );
}
?>