
<?php
class Video_LT{
  
    // database connection and table name
    private $conn;
    private $table_name = "Tbl_Video_LugarTuristico";

      // object properties
    public $ID_Video_LT;
    public $ID_Lugar_Turistico;
    public $VL_Descripcion;
    public $VL_URL;
    public $Nombre_Lugar_Turistico;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
  
  
  
  
  
  
  
  
  
  
   function ConsultaIdLT(){
        // query to read single record
     $query = "SELECT 
    			      v.ID_Video_LT, v.ID_Lugar_Turistico, l.LT_Nombre as Nombre_Lugar_Turistico, v.VL_Descripcion, v.VL_URL 
    		FROM
    			" . $this->table_name . " v 
        INNER JOIN 
    		    Tbl_Lugar_Turistico l 
    				  ON v.ID_Lugar_Turistico = l.ID_Lugar_Turistico
    		WHERE 
    			v.ID_Lugar_Turistico = ? ";
    
   $stmt = $this->conn->prepare( $query );

    // bind
    $stmt->bindParam(1, $this->ID_Lugar_Turistico);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
   }
  
  
  
  
  function read(){
  
    // select all query
    $query = "SELECT
                v.ID_Video_LT, v.ID_Lugar_Turistico, l.LT_Nombre as Nombre_Lugar_Turistico, v.VL_Descripcion, v.VL_URL
            FROM
                " . $this->table_name . " v 
            LEFT JOIN
                Tbl_Lugar_Turistico l
                    ON v.ID_Lugar_Turistico = l.ID_Lugar_Turistico";
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
} 
  

}
?>
