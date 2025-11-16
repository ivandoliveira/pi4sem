<?php
class Produto {
    private $conn;
    private $table_name = "Produto";

    public $idProduto;
    public $nomeProduto;
    public $descProduto;
    public $precProduto;
    public $descontoPromocao;
    public $idCategoria;
    public $ativoProduto;
    public $idUsuario;
    public $qtdMinEstoque;
    public $imagem;

    public function __construct($db){
        $this->conn = $db;
    }

    function create(){
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    nomeProduto = :nomeProduto,
                    descProduto = :descProduto,
                    precProduto = :precProduto,
                    descontoPromocao = :descontoPromocao,
                    idCategoria = :idCategoria,
                    ativoProduto = :ativoProduto,
                    idUsuario = :idUsuario,
                    qtdMinEstoque = :qtdMinEstoque,
                    imagem = :imagem";

        $stmt = $this->conn->prepare($query);

        $this->nomeProduto = htmlspecialchars(strip_tags($this->nomeProduto));
        
        $this->descProduto      = isset($this->descProduto) ? htmlspecialchars(strip_tags($this->descProduto)) : null;
        $this->descontoPromocao = isset($this->descontoPromocao) ? $this->descontoPromocao : 0.00;
        $this->ativoProduto     = isset($this->ativoProduto) ? $this->ativoProduto : 'S'; 
        $this->qtdMinEstoque    = isset($this->qtdMinEstoque) ? $this->qtdMinEstoque : 0;
        $this->imagem           = isset($this->imagem) ? $this->imagem : null;
        
        $this->precProduto = floatval($this->precProduto);
        $this->idCategoria = intval($this->idCategoria);
        $this->idUsuario = intval($this->idUsuario);


        $stmt->bindParam(":nomeProduto", $this->nomeProduto);
        $stmt->bindParam(":descProduto", $this->descProduto);
        $stmt->bindParam(":precProduto", $this->precProduto);
        $stmt->bindParam(":descontoPromocao", $this->descontoPromocao);
        $stmt->bindParam(":idCategoria", $this->idCategoria);
        $stmt->bindParam(":ativoProduto", $this->ativoProduto);
        $stmt->bindParam(":idUsuario", $this->idUsuario);
        $stmt->bindParam(":qtdMinEstoque", $this->qtdMinEstoque);
        $stmt->bindParam(":imagem", $this->imagem);

        if($stmt->execute()){
            $this->idProduto = $this->conn->lastInsertId(); 
            return true;
        }

        return false;
    }


    function consultaProdutosPorCategoria(){
        $query = "SELECT 
                    p.idProduto, p.nomeProduto, p.descProduto, p.precProduto, 
                    p.descontoPromocao, p.ativoProduto, p.idUsuario, p.imagem,
                    c.nomeCategoria,
                    u.nomeUsuario as nomeArtesao
                  FROM " . $this->table_name . " p
                  LEFT JOIN Categoria c ON p.idCategoria = c.idCategoria
                  LEFT JOIN Usuario u ON p.idUsuario = u.idUsuario
                  WHERE p.idCategoria = :idCategoria
                  ORDER BY p.nomeProduto ASC";

        $stmt = $this->conn->prepare($query);

        $this->idCategoria = htmlspecialchars(strip_tags($this->idCategoria));
        
        $stmt->bindParam(':idCategoria', $this->idCategoria);

        $stmt->execute();

        return $stmt;
    }

    function consultaTodosOsProdutos(){
        $query = "SELECT 
                    p.idProduto, p.nomeProduto, p.descProduto, p.precProduto, 
                    p.descontoPromocao, p.ativoProduto, p.imagem,
                    c.nomeCategoria,
                    u.nomeUsuario as nomeArtesao, u.idUsuario
                  FROM " . $this->table_name . " p
                  LEFT JOIN Categoria c ON p.idCategoria = c.idCategoria
                  LEFT JOIN Usuario u ON p.idUsuario = u.idUsuario
                  ORDER BY p.nomeProduto ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

}
?>