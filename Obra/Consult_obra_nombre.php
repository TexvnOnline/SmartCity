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
include_once '../objects/Obra.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$obra = new Obra($db);
// set ID property of record to read
$keywords=isset($_GET["nombre"]) ? $_GET["nombre"] : "";
  
// read the details of product to be edited
$stmt = $obra->Consulta_nombre($keywords);
$num = $stmt->rowCount();  
if($num>0){ 
    $obra_arr = array();
    $obra_arr["records"] = array();
    // create array
   while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $obra_item=array(
            "ID_Obra" =>  $ID_Obra,
            "OBR_Nombre" => $OBR_Nombre,
            "OBR_Descripcion" => $OBR_Descripcion,
            "ID_Tipo" => $ID_Tipo,
            "Tipo_Obra" => $Tipo_Obra,
            "OBR_Fecha_Inicio" => $OBR_Fecha_Inicio,
            "OBR_Fecha_Fin" => $OBR_Fecha_Fin,
            "OBR_Monto" => $OBR_Monto,
            "OBR_Coordenada_X" => $OBR_Coordenada_X,
            "OBR_Coordenada_Y" => $OBR_Coordenada_Y,
            "OBR_Dias_Calendarios" => $OBR_Dias_Calendarios
        );
        array_push($obra_arr["records"], $obra_item);
  }
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
