<?php
class Tipo_incidente{
    private $conn;
    private $table_name = "tbl_tipo_incidente";

    public $ID_Tipo_Ind;
    public $TIN_Nombre;
    public $TIN_Descripcion;


    public function __construct($db){
        $this->conn = $db;
    }
    function create(){
  
    $query = "INSERT INTO
                " . $this->table_name . "
            SET TIN_Nombre=:TIN_Nombre, 
            TIN_Descripcion=:TIN_Descripcion";

    $stmt = $this->conn->prepare($query);
  
    $this->TIN_Nombre=htmlspecialchars(strip_tags($this->TIN_Nombre));
    $this->TIN_Descripcion=htmlspecialchars(strip_tags($this->TIN_Descripcion));



    $stmt->bindParam(":TIN_Nombre", $this->TIN_Nombre);
    $stmt->bindParam(":TIN_Descripcion", $this->TIN_Descripcion);


    if($stmt->execute()){
        return true;
    }

    return false;
      
}


function read(){
    $query = "SELECT
        p.ID_Tipo_Ind, p.TIN_Nombre, p.TIN_Descripcion
        FROM
            " . $this->table_name . " p";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}
}
?>
