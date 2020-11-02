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
include_once '../objects/Video_LugarTuristico.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$videoLT= new Video_LT($db);
// set ID property of record to read


$videoLT->ID_Lugar_Turistico = isset($_GET['ID_Lugar_Turistico']) ? $_GET['ID_Lugar_Turistico'] : die();
  
$stmt = $videoLT->ConsultaIdLT();
$num = $stmt->rowCount();


if($num>0){
  
    // products array
    $videoLT_arr=array();
    $videoLT_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
    // create array
    $videoLT_item = array(
        "ID_Video_LT" =>  $ID_Video_LT,
        "ID_Lugar_Turistico" => $ID_Lugar_Turistico,
        "Nombre_Lugar_Turistico" => $Nombre_Lugar_Turistico,
        "VL_Descripcion" => $VL_Descripcion,
        "VL_URL" => $VL_URL
    );
  
  
    // make it json format
    array_push($videoLT_arr["records"], $videoLT_item);
}

 http_response_code(200);
  
    // show products data
    echo json_encode($videoLT_arr);
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
