<?php
class Categoria {
    private $conn;
    private $table_name = "Categoria";

    public $idCategoria;
    public $nomeCategoria;
    public $descCategoria;

    public function __construct($db){
        $this->conn = $db;
    }

    function create(){
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    nomeCategoria = :nomeCategoria,
                    descCategoria = :descCategoria";

        $stmt = $this->conn->prepare($query);

        $this->nomeCategoria = htmlspecialchars(strip_tags($this->nomeCategoria));
        $this->descCategoria = htmlspecialchars(strip_tags($this->descCategoria));

        if (empty($this->descCategoria)) {
             $this->descCategoria = null;
        }

        $stmt->bindParam(":nomeCategoria", $this->nomeCategoria);
        $stmt->bindParam(":descCategoria", $this->descCategoria);

        if($stmt->execute()){
            $this->idCategoria = $this->conn->lastInsertId(); 
            return true;
        }

        return false;
    }
}
?>