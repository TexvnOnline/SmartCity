<?php
class Eventos{
  
    // database connection and table name
    private $conn;
    private $table_name = "Tbl_Eventos";

  
    // object properties
    public $ID_Eventos;
    public $EVE_Nombres;
    public $EVE_Descripcion;
    public $EVE_Detalles;
    public $EVE_Fotografia;
    public $EVE_Fecha_Hora;
    public $EVE_Longitud;
    public $ID_Distrito;
    public $EVE_Latitud;
    public $Distrito;


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function read(){
  
    // select all query
    $query = "SELECT
                c.ID_Eventos, c.EVE_Nombres, c.EVE_Descripcion ,c.EVE_Detalles, c.EVE_Fotografia, c.EVE_Fecha_Hora, c.EVE_Longitud, c.ID_Distrito,d.DIS_Nombre as Distrito, c.EVE_Latitud
            FROM
                " . $this->table_name . " c
                LEFT JOIN
                    Tbl_Distrito d
                        ON c.ID_Distrito = d.ID_Distrito";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}

function Consulta_id(){
        // query to read single record
    $query = "SELECT
                o.ID_Eventos, o.EVE_Nombres, o.EVE_Descripcion, o.ID_Distrito, t.DIS_Nombre as Distrito, o.EVE_Detalles, o.EVE_Fotografia, o.EVE_Fecha_Hora, o.EVE_Longitud, o.EVE_Latitud
            FROM
                " . $this->table_name . " o
                LEFT JOIN
                    Tbl_Distrito t
                        ON o.ID_Distrito = t.ID_Distrito
            WHERE
                o.ID_Eventos = ?
            LIMIT
                0,1";
                // prepare query statement
    $stmt = $this->conn->prepare( $query );
  
    // bind id of product to be updated
    $stmt->bindParam(1, $this->ID_Eventos);
  
    // execute query
    $stmt->execute();
  
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    // set values to object properties
    $this->ID_Eventos = $row['ID_Eventos'];
    $this->EVE_Nombres = $row['EVE_Nombres'];
    $this->EVE_Descripcion = $row['EVE_Descripcion'];
    $this->ID_Distrito = $row['ID_Distrito'];
    $this->Distrito = $row['Distrito'];
    $this->EVE_Detalles = $row['EVE_Detalles'];
    $this->EVE_Fotografia = $row['EVE_Fotografia'];
    $this->EVE_Fecha_Hora = $row['EVE_Fecha_Hora'];
    $this->EVE_Longitud = $row['EVE_Longitud'];
    $this->EVE_Latitud = $row['EVE_Latitud'];
    }  
  function Consulta_distrito(){
        // query to read single record
     $query = "SELECT 
                    v.ID_Eventos, v.ID_Distrito, d.DIS_Nombre as Distrito, v.EVE_Descripcion, v.EVE_Nombres, v.EVE_Descripcion, v.EVE_Detalles, v.EVE_Fotografia, v.EVE_Fecha_Hora, v.EVE_Longitud, v.EVE_Latitud
            FROM
                " . $this->table_name . " v
            LEFT JOIN
                    Tbl_Distrito d
                        ON v.ID_Distrito = d.ID_Distrito
            WHERE 
                v.ID_Distrito = ? ";
    
   $stmt = $this->conn->prepare( $query );

    // bind
    $stmt->bindParam(1, $this->ID_Distrito);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
   } 
}
?>
