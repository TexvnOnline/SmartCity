<?php
class Recursos_Cercanos{
  
    // database connection and table name
    private $conn;
    private $table_name = "Tbl_Recursos_Cercanos";
  
    // object properties
    public $ID_Recursos;
    public $RES_Nombre;
    public $RES_Descripcion;
    public $RES_Tipo;
    public $RES_Hora_Atencion;
    public $RES_URL_Map;
    public $RES_Pagina_Web;
    public $RES_Telefono;
    public $RES_Facebook;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET RES_Nombre=:RES_Nombre, RES_Descripcion=:RES_Descripcion, RES_Tipo=:RES_Tipo, RES_Hora_Atencion=:RES_Hora_Atencion, RES_URL_Map=:RES_URL_Map, RES_Pagina_Web=:RES_Pagina_Web, RES_Telefono=:RES_Telefono, RES_Facebook=:RES_Facebook";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->RES_Nombre=htmlspecialchars(strip_tags($this->RES_Nombre));
    $this->RES_Descripcion=htmlspecialchars(strip_tags($this->RES_Descripcion));
    $this->RES_Tipo=htmlspecialchars(strip_tags($this->RES_Tipo));
    $this->RES_Hora_Atencion=htmlspecialchars(strip_tags($this->RES_Hora_Atencion));
    $this->RES_URL_Map=htmlspecialchars(strip_tags($this->RES_URL_Map));
    $this->RES_Pagina_Web=htmlspecialchars(strip_tags($this->RES_Pagina_Web));
    $this->RES_Telefono=htmlspecialchars(strip_tags($this->RES_Telefono));
    $this->RES_Facebook=htmlspecialchars(strip_tags($this->RES_Facebook));
    // bind values
    $stmt->bindParam(":RES_Nombre", $this->RES_Nombre);
    $stmt->bindParam(":RES_Descripcion", $this->RES_Descripcion);
    $stmt->bindParam(":RES_Tipo", $this->RES_Tipo);
    $stmt->bindParam(":RES_Hora_Atencion", $this->RES_Hora_Atencion);
    $stmt->bindParam(":RES_URL_Map", $this->RES_URL_Map);
    $stmt->bindParam(":RES_Pagina_Web", $this->RES_Pagina_Web);
    $stmt->bindParam(":RES_Telefono", $this->RES_Telefono);
    $stmt->bindParam(":RES_Facebook", $this->RES_Facebook);
    // execute query
    if($stmt->execute()){
        return true;
        
    }
    
    return false;
      
}
}
?>