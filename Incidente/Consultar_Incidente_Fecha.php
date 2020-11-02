<?PHP
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/Incidente.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare incidente object
$incidente = new Incidente($db);
  
// get keywords
$incidente->ID_Vehiculo = isset($_GET['ID_Vehiculo']) ? $_GET['ID_Vehiculo'] : die();
// query products
$stmt = $incidente->Consultafecha();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $incidente_arr=array();
    $incidente_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $incidente_item=array(
            "ID_Incidente" => $ID_Incidente,
            "ID_Vehiculo" => $ID_Vehiculo,
            "Placa_Vehiculo" => $Placa_Vehiculo,
            "ID_Usuario" => $ID_Usuario,
            "Usuario_Nombres" =>$Usuario_Nombres,
            "ind_Descripcion" => $ind_Descripcion,
            "ind_Fecha_Incidente" => $ind_Fecha_Incidente,
            "ID_Tipo_Ind" => $ID_Tipo_Ind,
            "Tipo_Incidente" => $Tipo_Incidente
        );
  
        array_push($incidente_arr["records"], $incidente_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data
    echo json_encode($incidente_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "Ningun incidente encontrado.")
    );
}
?>