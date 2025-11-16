<?php
class TipoPagamento {
    private $conn;
    private $table_name = "TipoPagamento";

    public $idTipoPagto;
    public $descTipoPagto;

    public function __construct($db){
        $this->conn = $db;
    }


    function create(){
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    idTipoPagto = :idTipoPagto,
                    descTipoPagto = :descTipoPagto";

        $stmt = $this->conn->prepare($query);

        $this->descTipoPagto = htmlspecialchars(strip_tags($this->descTipoPagto));
        
        $this->idTipoPagto = intval($this->idTipoPagto);

        $stmt->bindParam(":idTipoPagto", $this->idTipoPagto);
        $stmt->bindParam(":descTipoPagto", $this->descTipoPagto);

        // Executa a query
        if($stmt->execute()){
            return true;
        }

        return false;
    }
}
?>