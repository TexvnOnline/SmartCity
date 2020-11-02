<?php
class Lugarturistico{
  
    // database connection and table name
    private $conn;
    private $table_name = "Tbl_Lugar_Turistico";
  
    // object properties
    public $ID_Lugar_Turistico;
    public $LT_Nombre;
    public $LT_Descripcion;
    public $LT_URL_Map;
    public $ID_Distrito;
    public $Distrito;
    public $LT_Hora_Inicio;
    public $LT_Hora_Fin;
    public $LT_Latitud;
    public $LT_Longitud;


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET LT_Nombre=:LT_Nombre, LT_Descripcion=:LT_Descripcion, LT_URL_Map=:LT_URL_Map, ID_Distrito=:ID_Distrito, LT_Hora_Inicio=:LT_Hora_Inicio, LT_Hora_Fin=:LT_Hora_Fin, LT_Latitud=:LT_Latitud, LT_Longitud=:LT_Longitud";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->LT_Nombre=htmlspecialchars(strip_tags($this->LT_Nombre));
    $this->LT_Descripcion=htmlspecialchars(strip_tags($this->LT_Descripcion));
    $this->LT_URL_Map=htmlspecialchars(strip_tags($this->LT_URL_Map));
    $this->ID_Distrito=htmlspecialchars(strip_tags($this->ID_Distrito));
    $this->LT_Hora_Inicio=htmlspecialchars(strip_tags($this->LT_Hora_Inicio));
    $this->LT_Hora_Fin=htmlspecialchars(strip_tags($this->LT_Hora_Fin));
    $this->LT_Latitud=htmlspecialchars(strip_tags($this->LT_Latitud));
    $this->LT_Longitud=htmlspecialchars(strip_tags($this->LT_Longitud));

    // bind values
    $stmt->bindParam(":LT_Nombre", $this->LT_Nombre);
    $stmt->bindParam(":LT_Descripcion", $this->LT_Descripcion);
    $stmt->bindParam(":LT_URL_Map", $this->LT_URL_Map);
    $stmt->bindParam(":ID_Distrito", $this->ID_Distrito);
    $stmt->bindParam(":LT_Hora_Inicio", $this->LT_Hora_Inicio);
    $stmt->bindParam(":LT_Hora_Fin", $this->LT_Hora_Fin);
    $stmt->bindParam(":LT_Latitud", $this->LT_Latitud);
    $stmt->bindParam(":LT_Longitud", $this->LT_Longitud);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
    else{
        print_r($stmt->errorInfo());
    }
    return false;
      
    }
    function Consulta(){
        // query to read single record
    $query = "SELECT
                l.ID_Lugar_Turistico, l.LT_Nombre, l.LT_Descripcion, l.LT_URL_Map, l.ID_Distrito, d.DIS_Nombre as Distrito, l.LT_Hora_Inicio, l.LT_Hora_Fin, l.LT_Latitud, l.LT_Longitud
            FROM
                " . $this->table_name . " l
                LEFT JOIN
                    Tbl_Distrito d
                        ON l.ID_Distrito = d.ID_Distrito
            WHERE
                l.ID_Lugar_Turistico = ?
            LIMIT
                0,1";
                // prepare query statement
    $stmt = $this->conn->prepare( $query );
  
    // bind id of product to be updated
    $stmt->bindParam(1, $this->ID_Lugar_Turistico);
  
    // execute query
    $stmt->execute();
  
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    // set values to object properties
    $this->ID_Lugar_Turistico = $row['ID_Lugar_Turistico'];
    $this->LT_Nombre = $row['LT_Nombre'];
    $this->LT_Descripcion = $row['LT_Descripcion'];
    $this->LT_URL_Map = $row['LT_URL_Map'];
    $this->ID_Distrito = $row['ID_Distrito'];
    $this->Distrito = $row['Distrito'];
    $this->LT_Hora_Inicio = $row['LT_Hora_Inicio'];
    $this->LT_Hora_Fin = $row['LT_Hora_Fin'];
    $this->LT_Latitud = $row['LT_Latitud'];
    $this->LT_Longitud = $row['LT_Longitud'];
    }
  
  
 function delete(){
  

    $query = "DELETE FROM " . $this->table_name . " WHERE ID_Lugar_Turistico = ?";
  
    $stmt = $this->conn->prepare($query);
  
    $this->ID_Lugar_Turistico=htmlspecialchars(strip_tags($this->ID_Lugar_Turistico));
  
   $stmt->bindParam(1, $this->ID_Lugar_Turistico);
  
    if($stmt->execute()){
        return true;
    }
  
 }
  function update(){
    // query to insert record
    $query = "UPDATE
                " . $this->table_name . "
            SET 
            LT_Nombre = :LT_Nombre, 
            LT_Descripcion = :LT_Descripcion, 
            LT_URL_Map = :LT_URL_Map, 
            ID_Distrito = :ID_Distrito, 
            LT_Hora_Inicio = :LT_Hora_Inicio, 
            LT_Hora_Fin = :LT_Hora_Fin,
            LT_Latitud = :LT_Latitud, 
            LT_Longitud = :LT_Longitud
            WHERE
                ID_Lugar_Turistico = :ID_Lugar_Turistico";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->ID_Lugar_Turistico=htmlspecialchars(strip_tags($this->ID_Lugar_Turistico));
    $this->LT_Nombre=htmlspecialchars(strip_tags($this->LT_Nombre));
    $this->LT_Descripcion=htmlspecialchars(strip_tags($this->LT_Descripcion));
    $this->LT_URL_Map=htmlspecialchars(strip_tags($this->LT_URL_Map));
    $this->ID_Distrito=htmlspecialchars(strip_tags($this->ID_Distrito));
    $this->LT_Hora_Inicio=htmlspecialchars(strip_tags($this->LT_Hora_Inicio));
    $this->LT_Hora_Fin=htmlspecialchars(strip_tags($this->LT_Hora_Fin));
    $this->LT_Latitud=htmlspecialchars(strip_tags($this->LT_Latitud));
    $this->LT_Longitud=htmlspecialchars(strip_tags($this->LT_Longitud));
    // bind values
    $stmt->bindParam(":ID_Lugar_Turistico", $this->ID_Lugar_Turistico);
    $stmt->bindParam(":LT_Nombre", $this->LT_Nombre);
    $stmt->bindParam(":LT_Descripcion", $this->LT_Descripcion);
    $stmt->bindParam(":LT_URL_Map", $this->LT_URL_Map);
    $stmt->bindParam(":ID_Distrito", $this->ID_Distrito);
    $stmt->bindParam(":LT_Hora_Inicio", $this->LT_Hora_Inicio);
    $stmt->bindParam(":LT_Hora_Fin", $this->LT_Hora_Fin);
     $stmt->bindParam(":LT_Latitud", $this->LT_Latitud);
    $stmt->bindParam(":LT_Longitud", $this->LT_Longitud);
    // execute query
    if($stmt->execute()){
        return true;
        
    }
    
    return false;
}
      function read(){
  
    // select all query
    $query = "SELECT
                l.ID_Lugar_Turistico, l.LT_Nombre, l.LT_Descripcion, l.LT_URL_Map, l.ID_Distrito,d.DIS_Nombre as Distrito,l.LT_Hora_Inicio,l.LT_Hora_Fin, l.LT_Latitud, l.LT_Longitud
            FROM
                " . $this->table_name . " l
                LEFT JOIN
                    Tbl_Distrito d
                        ON l.ID_Distrito = d.ID_Distrito
            ";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}
  
}
?>
