<?php
class Endereco {
    private $conn;
    private $table_name = "Endereco";

    public $idEndereco;
    public $idCliente; 
    public $nomeEndereco;
    public $logradouroEndereco;
    public $numeroEndereco;
    public $CEPEndereco;
    public $complementoEndereco;
    public $cidadeEndereco;
    public $paisEndereco;
    public $UFEndereco;
    public $imagem;

    public function __construct($db){
        $this->conn = $db;
    }

  
    function create(){
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    idCliente = :idCliente,
                    nomeEndereco = :nomeEndereco,
                    logradouroEndereco = :logradouroEndereco,
                    numeroEndereco = :numeroEndereco,
                    CEPEndereco = :CEPEndereco,
                    complementoEndereco = :complementoEndereco,
                    cidadeEndereco = :cidadeEndereco,
                    paisEndereco = :paisEndereco,
                    UFEndereco = :UFEndereco,
                    imagem = :imagem";

        $stmt = $this->conn->prepare($query);

        $this->nomeEndereco       = htmlspecialchars(strip_tags($this->nomeEndereco));
        $this->logradouroEndereco = htmlspecialchars(strip_tags($this->logradouroEndereco));
        $this->numeroEndereco     = htmlspecialchars(strip_tags($this->numeroEndereco));
        $this->CEPEndereco        = htmlspecialchars(strip_tags($this->CEPEndereco));
        $this->cidadeEndereco     = htmlspecialchars(strip_tags($this->cidadeEndereco));
        $this->paisEndereco       = htmlspecialchars(strip_tags($this->paisEndereco));
        $this->UFEndereco         = htmlspecialchars(strip_tags($this->UFEndereco));
        
        $this->complementoEndereco = empty($this->complementoEndereco) ? null : htmlspecialchars(strip_tags($this->complementoEndereco));
        $this->imagem = empty($this->imagem) ? null : $this->imagem; 

        $stmt->bindParam(":idCliente", $this->idCliente);
        $stmt->bindParam(":nomeEndereco", $this->nomeEndereco);
        $stmt->bindParam(":logradouroEndereco", $this->logradouroEndereco);
        $stmt->bindParam(":numeroEndereco", $this->numeroEndereco);
        $stmt->bindParam(":CEPEndereco", $this->CEPEndereco);
        $stmt->bindParam(":complementoEndereco", $this->complementoEndereco);
        $stmt->bindParam(":cidadeEndereco", $this->cidadeEndereco);
        $stmt->bindParam(":paisEndereco", $this->paisEndereco);
        $stmt->bindParam(":UFEndereco", $this->UFEndereco);
        $stmt->bindParam(":imagem", $this->imagem);
        
        if($stmt->execute()){
            $this->idEndereco = $this->conn->lastInsertId(); 
            return true;
        }

        return false;
    }
}
?>