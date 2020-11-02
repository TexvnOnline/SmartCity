<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';

include_once '../objects/Vehiculo.php';
  
$database = new Database();
$db = $database->getConnection();
  
$vehiculo = new Vehiculo($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
$stmt = $vehiculo->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){

    $vehiculo_arr=array();
    $vehiculo_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
  
        $vehiculo_item=array(
            "VEH_Placa" => $VEH_Placa,
            "VEH_Color" => $VEH_Color,
            "VEH_Modelo" => $VEH_Modelo,
            "VEH_Marca" => $VEH_Marca,
            "ID_Tipo_Vehiculo" => $ID_Tipo_Vehiculo,
            "Tipo_Vehiculo" => $Tipo_Vehiculo,
            "ID_Conductor" => $ID_Conductor,
            "Nombre_Conductor" => $Nombre_Conductor
        );

        array_push($vehiculo_arr["records"], $vehiculo_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show sites data in json format
    echo json_encode($vehiculo_arr);
}
  
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "Tipo_incidente no encontrados.")
    );
}
?>

