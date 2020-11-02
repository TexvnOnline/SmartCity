<?php
class ComentarioObra{
  
    // database connection and table name
    private $conn;
    private $table_name = "Tbl_Comentario_Obra";
  
    // object properties
    public $ID_Comentario;
    public $ID_Obra;
    public $COM_Obra;
    public $COM_Calificacion;
    public $ID_Usuario;
    public $Obra;
    public $Nombre_Usuario;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET ID_Obra=:ID_Obra, COM_Obra=:COM_Obra, COM_Calificacion=:COM_Calificacion, ID_Usuario=:ID_Usuario";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->ID_Obra=htmlspecialchars(strip_tags($this->ID_Obra));
    $this->COM_Obra=htmlspecialchars(strip_tags($this->COM_Obra));
    $this->COM_Calificacion=htmlspecialchars(strip_tags($this->COM_Calificacion));
    $this->ID_Usuario=htmlspecialchars(strip_tags($this->ID_Usuario));

    // bind values
    $stmt->bindParam(":ID_Obra", $this->ID_Obra);
    $stmt->bindParam(":COM_Obra", $this->COM_Obra);
    $stmt->bindParam(":COM_Calificacion", $this->COM_Calificacion);
    $stmt->bindParam(":ID_Usuario", $this->ID_Usuario);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
    return false;
      
    }
    function Consulta(){
        // query to read single record
    $query = "SELECT
                c.ID_Obra, o.OBR_Nombre as Obra, c.ID_Comentario, c.COM_Obra, c.COM_Calificacion, c.ID_Usuario,CONCAT(u.US_Nombres,' ',u.US_Apellidos) as Nombre_Usuario
            FROM
                " . $this->table_name . " c
                LEFT JOIN
                    Tbl_Obra o
                        ON c.ID_Obra = o.ID_Obra
                LEFT JOIN
                    Tbl_Usuario u
                        ON c.ID_Usuario = u.ID_Usuario
            WHERE
                c.ID_Comentario = ?
            LIMIT
                0,1";
                // prepare query statement
    $stmt = $this->conn->prepare( $query );
  
    // bind id of product to be updated
    $stmt->bindParam(1, $this->ID_Comentario);
  
    // execute query
    $stmt->execute();
  
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    // set values to object properties
    $this->ID_Comentario = $row['ID_Comentario'];
    $this->ID_Obra = $row['ID_Obra'];
    $this->Obra = $row['Obra'];
    $this->COM_Obra = $row['COM_Obra'];
    $this->COM_Calificacion = $row['COM_Calificacion'];
    $this->ID_Usuario = $row['ID_Usuario'];
    $this->Nombre_Usuario = $row['Nombre_Usuario'];
    }
    function update(){
    // query to insert record
    $query = "UPDATE
                " . $this->table_name . "
            SET 
            ID_Obra = :ID_Obra, 
            COM_Obra = :COM_Obra, 
            COM_Calificacion = :COM_Calificacion, 
            ID_Usuario = :ID_Usuario
            WHERE
                ID_Comentario = :ID_Comentario";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->ID_Comentario=htmlspecialchars(strip_tags($this->ID_Comentario));
    $this->ID_Obra=htmlspecialchars(strip_tags($this->ID_Obra));
    $this->COM_Obra=htmlspecialchars(strip_tags($this->COM_Obra));
    $this->COM_Calificacion=htmlspecialchars(strip_tags($this->COM_Calificacion));
    $this->ID_Usuario=htmlspecialchars(strip_tags($this->ID_Usuario));

    // bind values
    $stmt->bindParam(":ID_Comentario", $this->ID_Comentario);
    $stmt->bindParam(":ID_Obra", $this->ID_Obra);
    $stmt->bindParam(":COM_Obra", $this->COM_Obra);
    $stmt->bindParam(":COM_Calificacion", $this->COM_Calificacion);
    $stmt->bindParam(":ID_Usuario", $this->ID_Usuario);
    // execute query
    if($stmt->execute()){
        return true;
        
    }
    
    return false;
}
function read(){
  
    // select all query
    $query = "SELECT
                c.ID_Obra, o.OBR_Nombre as Obra, c.ID_Comentario, c.COM_Obra, c.COM_Calificacion, c.ID_Usuario,CONCAT(u.US_Nombres,' ',u.US_Apellidos) as Nombre_Usuario
            FROM
                " . $this->table_name . " c
                LEFT JOIN
                    Tbl_Obra o
                        ON c.ID_Obra = o.ID_Obra
                LEFT JOIN
                    Tbl_Usuario u
                        ON c.ID_Usuario = u.ID_Usuario";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}
  
  
  
  
  
  
  
  
  function delete(){
  
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE ID_Comentario = ?";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->ID_Comentario=htmlspecialchars(strip_tags($this->ID_Comentario));
  
    // bind id of record to delete
    $stmt->bindParam(1, $this->ID_Comentario);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
    return false;
}
  
  
  
  
  
  
  
  
  
  
function Consulta_Nombre(){
  
    // select all query
    $query = "SELECT
                c.ID_Obra, o.OBR_Nombre as Obra, c.ID_Comentario, c.COM_Obra, c.COM_Calificacion, c.ID_Usuario,CONCAT(u.US_Nombres,' ',u.US_Apellidos) as Nombre_Usuario
            FROM
                " . $this->table_name . " c
                LEFT JOIN
                    Tbl_Obra o
                        ON c.ID_Obra = o.ID_Obra
                LEFT JOIN
                    Tbl_Usuario u
                        ON c.ID_Usuario = u.ID_Usuario
                WHERE
                c.ID_Usuario = ?";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->ID_Usuario);
    // execute query
    $stmt->execute();
  
    return $stmt;
}
  function Consulta_Obra(){
  
    // select all query
    $query = "SELECT
                c.ID_Obra, o.OBR_Nombre as Obra, c.ID_Comentario, c.COM_Obra, c.COM_Calificacion, c.ID_Usuario,CONCAT(u.US_Nombres,' ',u.US_Apellidos) as Nombre_Usuario
            FROM
                " . $this->table_name . " c
                LEFT JOIN
                    Tbl_Obra o
                        ON c.ID_Obra = o.ID_Obra
                LEFT JOIN
                    Tbl_Usuario u
                        ON c.ID_Usuario = u.ID_Usuario
                WHERE
                c.ID_Obra = ?";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->ID_Obra);
    // execute query
    $stmt->execute();
  
    return $stmt;
}
}
?>
