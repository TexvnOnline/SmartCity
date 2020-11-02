<?php
class Obra{
  
    // database connection and table name
    private $conn;
    private $table_name = "Tbl_Obra";
  
    // object properties
    public $ID_Obra;
    public $OBR_Nombre;
    public $OBR_Descripcion;
    public $ID_Tipo;
    public $Tipo_Obra;
    public $OBR_Fecha_Inicio;
    public $OBR_Fecha_Fin;
    public $OBR_Monto;
    public $OBR_Coordenada_X;
    public $OBR_Coordenada_Y;
    public $OBR_Dias_Calendarios;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET 
            OBR_Nombre=:OBR_Nombre, 
            OBR_Descripcion=:OBR_Descripcion, 
            ID_Tipo=:ID_Tipo, 
            OBR_Fecha_Inicio=:OBR_Fecha_Inicio, 
            OBR_Fecha_Fin=:OBR_Fecha_Fin, 
            OBR_Monto=:OBR_Monto, 
            OBR_Coordenada_X=:OBR_Coordenada_X, 
            OBR_Coordenada_Y=:OBR_Coordenada_Y, 
            OBR_Dias_Calendarios=:OBR_Dias_Calendarios";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->OBR_Nombre=htmlspecialchars(strip_tags($this->OBR_Nombre));
    $this->OBR_Descripcion=htmlspecialchars(strip_tags($this->OBR_Descripcion));
    $this->ID_Tipo=htmlspecialchars(strip_tags($this->ID_Tipo));
    $this->OBR_Fecha_Inicio=htmlspecialchars(strip_tags($this->OBR_Fecha_Inicio));
    $this->OBR_Fecha_Fin=htmlspecialchars(strip_tags($this->OBR_Fecha_Fin));
    $this->OBR_Monto=htmlspecialchars(strip_tags($this->OBR_Monto));
    $this->OBR_Coordenada_X=htmlspecialchars(strip_tags($this->OBR_Coordenada_X));
    $this->OBR_Coordenada_Y=htmlspecialchars(strip_tags($this->OBR_Coordenada_Y));
    $this->OBR_Dias_Calendarios=htmlspecialchars(strip_tags($this->OBR_Dias_Calendarios));
    // bind values
    $stmt->bindParam(":OBR_Nombre", $this->OBR_Nombre);
    $stmt->bindParam(":OBR_Descripcion", $this->OBR_Descripcion);
    $stmt->bindParam(":ID_Tipo", $this->ID_Tipo);
    $stmt->bindParam(":OBR_Fecha_Inicio", $this->OBR_Fecha_Inicio);
    $stmt->bindParam(":OBR_Fecha_Fin", $this->OBR_Fecha_Fin);
    $stmt->bindParam(":OBR_Monto", $this->OBR_Monto);
    $stmt->bindParam(":OBR_Coordenada_X", $this->OBR_Coordenada_X);
    $stmt->bindParam(":OBR_Coordenada_Y", $this->OBR_Coordenada_Y);
    $stmt->bindParam(":OBR_Dias_Calendarios", $this->OBR_Dias_Calendarios);
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}
function Consulta_nombre($keywords){
        // query to read single record
    $query = "SELECT
                o.ID_Obra, o.OBR_Nombre, o.OBR_Descripcion, o.ID_Tipo, t.TPO_Nombre as Tipo_Obra, o.OBR_Fecha_Inicio, o.OBR_Fecha_Fin, o.OBR_Monto, o.OBR_Coordenada_X, o.OBR_Coordenada_Y, o.OBR_Dias_Calendarios
            FROM
                " . $this->table_name . " o
                LEFT JOIN
                    Tbl_Tipo_Obra t
                        ON o.ID_Tipo = t.ID_Tipo
            WHERE
                o.OBR_Nombre LIKE ?
                ";
                // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
  
    // bind
    $stmt->bindParam(1, $keywords);
    
    // execute query
    $stmt->execute();
  
    return $stmt;
    }

function Consulta_id(){
        // query to read single record
    $query = "SELECT
                o.ID_Obra, o.OBR_Nombre, o.OBR_Descripcion, o.ID_Tipo, t.TPO_Nombre as Tipo_Obra, o.OBR_Fecha_Inicio, o.OBR_Fecha_Fin, o.OBR_Monto, o.OBR_Coordenada_X, o.OBR_Coordenada_Y, o.OBR_Dias_Calendarios
            FROM
                " . $this->table_name . " o
                LEFT JOIN
                    Tbl_Tipo_Obra t
                        ON o.ID_Tipo = t.ID_Tipo
            WHERE
                o.ID_OBRA = ?
            LIMIT
                0,1";
                // prepare query statement
    $stmt = $this->conn->prepare( $query );
  
    // bind id of product to be updated
    $stmt->bindParam(1, $this->ID_Obra);
  
    // execute query
    $stmt->execute();
  
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    // set values to object properties
    $this->ID_Obra = $row['ID_Obra'];
    $this->OBR_Nombre = $row['OBR_Nombre'];
    $this->OBR_Descripcion = $row['OBR_Descripcion'];
    $this->ID_Tipo = $row['ID_Tipo'];
    $this->Tipo_Obra = $row['Tipo_Obra'];
    $this->OBR_Fecha_Inicio = $row['OBR_Fecha_Inicio'];
    $this->OBR_Fecha_Fin = $row['OBR_Fecha_Fin'];
    $this->OBR_Monto = $row['OBR_Monto'];
    $this->OBR_Coordenada_X = $row['OBR_Coordenada_X'];
    $this->OBR_Coordenada_Y = $row['OBR_Coordenada_Y'];
    }
  function read(){
  
    // select all query
    $query = "SELECT
                o.ID_Obra,o.OBR_Nombre, o.OBR_Descripcion, o.OBR_Fecha_Inicio , o.OBR_Fecha_Fin, p.PER_Nombres as Encargado_Nombre, p.PER_Apellidos as Encargado_Apellidos, e.EQ_Cargo as Encargado_Cargo, f.FO_FOTO as Obra_Fotografia, o.OBR_Monto, o.OBR_Dias_Calendarios, o.OBR_Coordenada_X, o.OBR_Coordenada_Y
            FROM
                " . $this->table_name . " o
                LEFT JOIN
                    Tbl_Equipo e
                        ON o.ID_Obra = e.ID_Obra
                LEFT JOIN
                    Tbl_Persona p
                        ON e.ID_Persona = p.ID_Persona
                LEFT JOIN
                    Tbl_Fotografia_Obra f
                        ON o.ID_Obra = f.ID_Obra";

  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}
}
?>
