<?PHP
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/Comentario_Obra.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$comment = new ComentarioObra($db);
// set ID property of record to read
$comment->ID_Obra = isset($_GET['ID_Obra']) ? $_GET['ID_Obra'] : die();
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
$stmt = $comment->Consulta_Obra();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $comment_arr=array();
    $comment_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $comment_item=array(
            "ID_Comentario" =>  $ID_Comentario,
            "ID_Obra" => $ID_Obra,
            "Obra" => $Obra,
            "COM_Obra" => $COM_Obra,
            "COM_Calificacion" => $COM_Calificacion,
            "ID_Usuario" => $ID_Usuario,
            "Nombre_Usuario" => $Nombre_Usuario
        );
  
        array_push($comment_arr["records"], $comment_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show sites data in json format
    echo json_encode($comment_arr);
}
  
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "Comentarios no encontrados.")
    );
}

?>