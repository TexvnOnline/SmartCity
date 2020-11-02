<?php
class Vehiculo{
  
    // database connection and table name
    private $conn;
    private $table_name = "Tbl_Vehiculo";
    //private $table_name = "Tbl_Conductor";
    //private $table_name = "Tbl_Tipo_Vehiculo";
  
    // object properties
    public $ID_Vehiculo;
    public $VEH_Placa;
    public $VEH_Color;
    public $VEH_Modelo;
    public $VEH_Marca;
    public $ID_Tipo_Vehiculo;
    public $ID_Conductor;
    public $Nombre_Conductor;
    public $Tipo_Vehiculo;
  

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET VEH_Placa=:VEH_Placa, VEH_Color=:VEH_Color, VEH_Modelo=:VEH_Modelo, VEH_Marca=:VEH_Marca, ID_Tipo_Vehiculo=:ID_Tipo_Vehiculo, ID_Conductor=:ID_Conductor";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->VEH_Placa=htmlspecialchars(strip_tags($this->VEH_Placa));
    $this->VEH_Color=htmlspecialchars(strip_tags($this->VEH_Color));
    $this->VEH_Modelo=htmlspecialchars(strip_tags($this->VEH_Modelo));
    $this->VEH_Marca=htmlspecialchars(strip_tags($this->VEH_Marca));
    $this->ID_Tipo_Vehiculo=htmlspecialchars(strip_tags($this->ID_Tipo_Vehiculo));
    $this->ID_Conductor=htmlspecialchars(strip_tags($this->ID_Conductor));
    // bind values

    $stmt->bindParam(":VEH_Placa", $this->VEH_Placa);
    $stmt->bindParam(":VEH_Color", $this->VEH_Color);
    $stmt->bindParam(":VEH_Modelo", $this->VEH_Modelo);
    $stmt->bindParam(":VEH_Marca", $this->VEH_Marca);
    $stmt->bindParam(":ID_Tipo_Vehiculo", $this->ID_Tipo_Vehiculo);
    $stmt->bindParam(":ID_Conductor", $this->ID_Conductor);

    // execute query
    if($stmt->execute()){
        return true;
    }

    return false;
      
}


  function Consulta(){
        // query to read single record
    $query = "SELECT
                v.ID_Vehiculo, v.VEH_Placa, v.VEH_Color, v.VEH_Modelo, v.VEH_Marca, v.ID_Tipo_Vehiculo, t.TV_Nombre as Tipo_Vehiculo,v.ID_Conductor,CONCAT(c.CON_Nombre,' ',c.CON_Apellidos) as Nombre_Conductor
            FROM
                " . $this->table_name . " v
                LEFT JOIN
                    Tbl_Tipo_Vehiculo t
                        ON v.ID_Tipo_Vehiculo = t.ID_Tipo_Vehiculo
                LEFT JOIN
                    Tbl_Conductor c
                        ON v.ID_Conductor = c.ID_Conductor
            WHERE
                v.VEH_Placa = ?
            LIMIT
                0,1";
                // prepare query statement
    $stmt = $this->conn->prepare( $query );
  
    // bind id of product to be updated
    $stmt->bindParam(1, $this->VEH_Placa);
  
    // execute query
    $stmt->execute();
  
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    // set values to object properties
    $this->ID_Vehiculo = $row['ID_Vehiculo'];
    $this->VEH_Placa = $row['VEH_Placa'];
    $this->VEH_Color = $row['VEH_Color'];
    $this->VEH_Modelo = $row['VEH_Modelo'];
    $this->VEH_Marca = $row['VEH_Marca'];
    $this->ID_Tipo_Vehiculo = $row['ID_Tipo_Vehiculo'];
    $this->Tipo_Vehiculo = $row['Tipo_Vehiculo'];
    $this->ID_Conductor = $row['ID_Conductor'];
    $this->Nombre_Conductor = $row['Nombre_Conductor'];
    }


    function read(){
  
        // select all query
        $query = "SELECT

                    v.ID_Vehiculo,
                    v.VEH_Placa,
                    v.VEH_Color,
                    v.VEH_Modelo,
                    v.VEH_Marca

                FROM
                    " . $this->table_name . " v
                ";
      

        // prepare query statement
        $stmt = $this->conn->prepare($query);
      
        // execute query
        $stmt->execute();
      
        return $stmt;
    }





}
?>
