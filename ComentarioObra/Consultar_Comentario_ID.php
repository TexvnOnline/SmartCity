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
$comment->ID_Comentario = isset($_GET['ID_Comentario']) ? $_GET['ID_Comentario'] : die();
  
// read the details of product to be edited
$comment->Consulta();
  
if($comment->ID_Comentario!=null){
    // create array
    $comment_arr = array(
        "ID_Comentario" =>  $comment->ID_Comentario,
        "ID_Obra" => $comment->ID_Obra,
        "Obra" => $comment->Obra,
        "COM_Obra" => $comment->COM_Obra,
        "COM_Calificacion" => $comment->COM_Calificacion,
        "ID_Usuario" => $comment->ID_Usuario,
        "Nombre_Usuario" => $comment->Nombre_Usuario
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($comment_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user product does not exist
    echo json_encode(array("message" => "Comentario no existe."));
}


?>