<?php
class Usuario{
  
    // database connection and table name
    private $conn;
    private $table_name = "Tbl_Usuario";
  
    // object properties
    public $ID_Usuario;
    public $US_Nombres;
    public $US_Apellidos;
    public $US_Direccion;
    public $US_Fecha_Nacimiento;
    public $US_Nacionalidad;
    public $US_Telefono;
    public $US_Email;
    public $US_Contrasena;
    public $US_Tipo;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET US_Nombres=:US_Nombres, US_Apellidos=:US_Apellidos, US_Direccion=:US_Direccion, US_Fecha_Nacimiento=:US_Fecha_Nacimiento, US_Nacionalidad=:US_Nacionalidad, US_Telefono=:US_Telefono, US_Email=:US_Email, US_Contrasena=:US_Contrasena, US_Tipo=:US_Tipo";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->US_Nombres=htmlspecialchars(strip_tags($this->US_Nombres));
    $this->US_Apellidos=htmlspecialchars(strip_tags($this->US_Apellidos));
    $this->US_Direccion=htmlspecialchars(strip_tags($this->US_Direccion));
    $this->US_Fecha_Nacimiento=htmlspecialchars(strip_tags($this->US_Fecha_Nacimiento));
    $this->US_Nacionalidad=htmlspecialchars(strip_tags($this->US_Nacionalidad));
    $this->US_Telefono=htmlspecialchars(strip_tags($this->US_Telefono));
    $this->US_Email=htmlspecialchars(strip_tags($this->US_Email));
    $this->US_Contrasena=htmlspecialchars(strip_tags($this->US_Contrasena));
    $this->US_Tipo=htmlspecialchars(strip_tags($this->US_Tipo));
    // bind values
    $stmt->bindParam(":US_Nombres", $this->US_Nombres);
    $stmt->bindParam(":US_Apellidos", $this->US_Apellidos);
    $stmt->bindParam(":US_Direccion", $this->US_Direccion);
    $stmt->bindParam(":US_Fecha_Nacimiento", $this->US_Fecha_Nacimiento);
    $stmt->bindParam(":US_Nacionalidad", $this->US_Nacionalidad);
    $stmt->bindParam(":US_Telefono", $this->US_Telefono);
    $stmt->bindParam(":US_Email", $this->US_Email);
    $stmt->bindParam(":US_Contrasena", $this->US_Contrasena);
    $stmt->bindParam(":US_Tipo", $this->US_Tipo);
    // execute query
    if($stmt->execute()){
        return true;
        
    }
    
    return false;
      
}
  
  
  
  
  function createIncidente(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET US_Nombres=:US_Nombres, US_Apellidos=:US_Apellidos, US_Email=:US_Email, US_Contrasena=:US_Contrasena";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->US_Nombres=htmlspecialchars(strip_tags($this->US_Nombres));
    $this->US_Apellidos=htmlspecialchars(strip_tags($this->US_Apellidos));
    $this->US_Email=htmlspecialchars(strip_tags($this->US_Email));
    $this->US_Contrasena=htmlspecialchars(strip_tags($this->US_Contrasena));
    // bind values
    $stmt->bindParam(":US_Nombres", $this->US_Nombres);
    $stmt->bindParam(":US_Apellidos", $this->US_Apellidos);
    $stmt->bindParam(":US_Email", $this->US_Email);
    $stmt->bindParam(":US_Contrasena", $this->US_Contrasena);
    // execute query
    if($stmt->execute()){
        return true;
        
    }
    
    return false;
      
}
  
  
  
  
function login(){
        // select all query with user inputed username and password
        $query = "SELECT
                    `ID_Usuario`, `US_Email`, `US_Contrasena`
                FROM
                    " . $this->table_name . " 
                WHERE
                    US_Email='".$this->US_Email."' AND US_Contrasena='".$this->US_Contrasena."'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }

  
  function cambiar_password(){
        // select all query with user inputed username and password
        // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                US_Contrasena = :US_Contrasena
            WHERE
                US_Email = :US_Email";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
        // sanitize
    $this->US_Contrasena=htmlspecialchars(strip_tags($this->US_Contrasena));
    $this->US_Email=htmlspecialchars(strip_tags($this->US_Email));
       // bind new values
    $stmt->bindParam(':US_Contrasena', $this->US_Contrasena);
    $stmt->bindParam(':US_Email', $this->US_Email);
    // execute the query
    if($stmt->execute()){
        return true;
    }
  else {
        print_r($stmt->errorInfo());
    }
    return false;
}
  
  
  
function ConsultaID(){
        // query to read single record
   // $query = "SELECT ID_Usuario, US_Nombres, US_Apellidos, US_Direccion, US_Fecha_Nacimiento, US_Nacionalidad, US_Telefono, US_Email FROM " . $this->table_name . " WHERE ID_Usuario = ?";
          $query = "SELECT
                    `ID_Usuario`, `US_Nombres`, `US_Apellidos`, `US_Direccion`, `US_Fecha_Nacimiento`, `US_Nacionalidad`, `US_Telefono`, `US_Email`
                FROM
                    " . $this->table_name . " 
                WHERE
                    ID_Usuario='".$this->ID_Usuario."'";
                     $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }
  
  
  
  
  
  
  function ConsultaEmail(){
        // query to read single record
   // $query = "SELECT ID_Usuario, US_Nombres, US_Apellidos, US_Direccion, US_Fecha_Nacimiento, US_Nacionalidad, US_Telefono, US_Email FROM " . $this->table_name . " WHERE ID_Usuario = ?";
          $query = "SELECT
                    `ID_Usuario`, `US_Nombres`, `US_Apellidos`, `US_Direccion`, `US_Fecha_Nacimiento`, `US_Nacionalidad`, `US_Telefono`, `US_Email`
                FROM
                    " . $this->table_name . " 
                WHERE
                    US_Email='".$this->US_Email."'";
                     $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    } 
  
  
  
  
  
  
  
  
function update(){
    // query to insert record
    $query = "UPDATE
                " . $this->table_name . "
            SET 
            US_Nombres = :US_Nombres,
            US_Apellidos = :US_Apellidos, 
            US_Direccion = :US_Direccion,
            US_Fecha_Nacimiento = :US_Fecha_Nacimiento,
            US_Nacionalidad = :US_Nacionalidad, 
            US_Telefono = :US_Telefono,
            US_Email = :US_Email
            WHERE
                ID_Usuario = :ID_Usuario";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->US_Nombres=htmlspecialchars(strip_tags($this->US_Nombres));
    $this->US_Apellidos=htmlspecialchars(strip_tags($this->US_Apellidos));
    $this->US_Direccion=htmlspecialchars(strip_tags($this->US_Direccion));
    $this->US_Fecha_Nacimiento=htmlspecialchars(strip_tags($this->US_Fecha_Nacimiento));
    $this->US_Nacionalidad=htmlspecialchars(strip_tags($this->US_Nacionalidad));
    $this->US_Telefono=htmlspecialchars(strip_tags($this->US_Telefono));
    $this->US_Email=htmlspecialchars(strip_tags($this->US_Email));
    $this->ID_Usuario=htmlspecialchars(strip_tags($this->ID_Usuario));
    // bind values
    $stmt->bindParam(":US_Nombres", $this->US_Nombres);
    $stmt->bindParam(":US_Apellidos", $this->US_Apellidos);
    $stmt->bindParam(":US_Direccion", $this->US_Direccion);
    $stmt->bindParam(":US_Fecha_Nacimiento", $this->US_Fecha_Nacimiento);
    $stmt->bindParam(":US_Nacionalidad", $this->US_Nacionalidad);
    $stmt->bindParam(":US_Telefono", $this->US_Telefono);
    $stmt->bindParam(":US_Email", $this->US_Email);
    $stmt->bindParam(":ID_Usuario", $this->ID_Usuario);
    // execute query
    if($stmt->execute()){
        return true;
        
    }
    
    return false;
}
}
?>
