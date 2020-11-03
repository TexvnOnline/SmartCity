<?php
class Provincia{
  
    private $conn;
    private $table_name = "Tbl_provincia";

  
    // object properties
    public $ID_Provincia;
    public $PROV_Nombre;


    public function __construct($db){
        $this->conn = $db;
    }

    function create(){
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET PROV_Nombre=:PROV_Nombre";
        $stmt = $this->conn->prepare($query);
        $this->PROV_Nombre=htmlspecialchars(strip_tags($this->PROV_Nombre));

        $stmt->bindParam(":PROV_Nombre", $this->PROV_Nombre);
        if($stmt->execute()){
            return true;
        }
        return false;   
    }
    function read(){
        $query = "SELECT
            p.ID_Provincia, p.PROV_Nombre
            FROM
                " . $this->table_name . " p";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

}
?>
