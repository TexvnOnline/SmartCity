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
include_once '../objects/Conductor.php';
  
$database = new Database();
$db = $database->getConnection();
  
$conductor = new Conductor($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
$stmt = $conductor->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $conductor_arr=array();
    $conductor_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $conductor_item=array(
            "ID_Conductor" =>  $ID_Conductor,
            "CON_Nombre" => $CON_Nombre,
            "CON_Apellidos" => $CON_Apellidos,
            "CON_Telefono" => $CON_Telefono,
            "CON_Direccion" => $CON_Direccion,
            "CON_Licencia" => $CON_Licencia,
            "CON_Fotografia_Perfil" => $CON_Fotografia_Perfil,
            "ID_Empresa_Transp" => $ID_Empresa_Transp,
            "CON_Latitud" => $CON_Latitud,
            "CON_Longitud" => $CON_Longitud,
            "CON_Status" => $CON_Status,
            "CON_FCM" => $CON_FCM,     
            "CON_Fotografia_Licencia" => $CON_Fotografia_Licencia,
            "CON_Email" => $CON_Email   
        );
  
        array_push($conductor_arr["records"], $conductor_item);
    }
// set response code - 200 OK
    http_response_code(200);
  
    // show sites data in json format
    echo json_encode($conductor_arr);
}
  
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "Conductor no encontrados.")
    );
}
?>