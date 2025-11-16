<?php
class StatusPedido {
    private $conn;
    private $table_name = "StatusPedido";

    public $idStatus;
    public $descStatus;

    public function __construct($db){
        $this->conn = $db;
    }


    function create(){
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    idStatus = :idStatus,
                    descStatus = :descStatus";

        $stmt = $this->conn->prepare($query);

        $this->descStatus = htmlspecialchars(strip_tags($this->descStatus));
        
        $this->idStatus = intval($this->idStatus);

        $stmt->bindParam(":idStatus", $this->idStatus);
        $stmt->bindParam(":descStatus", $this->descStatus);

        if($stmt->execute()){
            return true;
        }

        return false;
    }
}
?>