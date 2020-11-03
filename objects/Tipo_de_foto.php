<?php
class Tipo_de_foto{
    private $conn;
    private $table_name = "tbl_tipo_fotografia_lt";

    public $ID_Tipo_Fotografia;
    public $TFL_Descripcion	;
    public $TFL_Tamaño;
    public $TFL_Detalles;
    
       

    public function __construct($db){
        $this->conn = $db;
    }
    function create(){
  
    $query = "INSERT INTO
                " . $this->table_name . "
            SET TFL_Descripcion=:TFL_Descripcion, 
            SET TFL_Tamaño=:TFL_Tamaño, 
            TFL_Detalles=:TFL_Detalles";

            
           
    $stmt = $this->conn->prepare($query);
  
    $this->TFL_Descripcion=htmlspecialchars(strip_tags($this->TFL_Descripcion));
    $this->TFL_Tamaño=htmlspecialchars(strip_tags($this->TFL_Tamaño));
    $this->TFL_Detalles=htmlspecialchars(strip_tags($this->TFL_Detalles));



    $stmt->bindParam(":TFL_Descripcion", $this->TFL_Descripcion);
    $stmt->bindParam(":TFL_Tamaño", $this->TFL_Tamaño);
    $stmt->bindParam(":TFL_Detalles", $this->TFL_Detalles);


    if($stmt->execute()){
        return true;
    }

    return false;
      
}


function read(){
    $query = "SELECT
        p.ID_Tipo_Fotografia,
        p.TFL_Descripcion,
        p.TFL_Tamaño,
        p.TFL_Detalles

        FROM
            " . $this->table_name . " p";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}
}
?>
