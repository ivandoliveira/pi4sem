<?php
class Aplicacao {
    private $conn;
    private $table_name = "Aplicacao";

    public $idAplicacao;
    public $DescAplicacao;
    public $TipoAplicacao;

    public function __construct($db){
        $this->conn = $db;
    }


    function create(){
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    idAplicacao = :idAplicacao,
                    DescAplicacao = :DescAplicacao,
                    TipoAplicacao = :TipoAplicacao";

        $stmt = $this->conn->prepare($query);

        $this->DescAplicacao = htmlspecialchars(strip_tags($this->DescAplicacao));
        $this->TipoAplicacao = htmlspecialchars(strip_tags($this->TipoAplicacao));
        
        $this->idAplicacao = intval($this->idAplicacao);

        $stmt->bindParam(":idAplicacao", $this->idAplicacao);
        $stmt->bindParam(":DescAplicacao", $this->DescAplicacao);
        $stmt->bindParam(":TipoAplicacao", $this->TipoAplicacao);

        if($stmt->execute()){
            return true;
        }

        return false;
    }
}
?>