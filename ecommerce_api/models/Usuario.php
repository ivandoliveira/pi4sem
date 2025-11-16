<?php
class Usuario {
    private $conn;
    private $table_name = "Usuario";

    public $idUsuario;
    public $loginUsuario;
    public $senhaUsuario;
    public $nomeUsuario;
    public $tipoPerfil;
    public $imagem;
    public $usuarioAtivo;

    public function __construct($db){
        $this->conn = $db;
    }

    function create(){
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    loginUsuario = :loginUsuario,
                    senhaUsuario = :senhaUsuario,
                    nomeUsuario = :nomeUsuario,
                    tipoPerfil = :tipoPerfil,
                    imagem = :imagem,
                    usuarioAtivo = :usuarioAtivo";

        $stmt = $this->conn->prepare($query);

        $this->loginUsuario   = htmlspecialchars(strip_tags($this->loginUsuario));
        $this->nomeUsuario    = htmlspecialchars(strip_tags($this->nomeUsuario));
        $this->tipoPerfil     = htmlspecialchars(strip_tags($this->tipoPerfil));
        
        $this->senhaUsuario   = password_hash($this->senhaUsuario, PASSWORD_BCRYPT);
        
        $this->usuarioAtivo   = 1; 

        $stmt->bindParam(":loginUsuario", $this->loginUsuario);
        $stmt->bindParam(":senhaUsuario", $this->senhaUsuario);
        $stmt->bindParam(":nomeUsuario", $this->nomeUsuario);
        $stmt->bindParam(":tipoPerfil", $this->tipoPerfil);
        $stmt->bindParam(":imagem", $this->imagem);
        $stmt->bindParam(":usuarioAtivo", $this->usuarioAtivo);

        if($stmt->execute()){
            $this->idUsuario = $this->conn->lastInsertId(); 
            return true;
        }

        return false;
    }

    function consultaProdutosDoVendedor(){
        $query = "SELECT 
                    u.idUsuario, 
                    u.nomeUsuario, 
                    u.loginUsuario, 
                    u.tipoPerfil,
                    u.imagem,
                    COUNT(p.idProduto) AS total_produtos
                  FROM Usuario u
                  LEFT JOIN Produto p 
                    ON u.idUsuario = p.idUsuario
                  WHERE u.tipoPerfil = 'V' 
                  GROUP BY u.idUsuario, u.nomeUsuario, u.loginUsuario, u.tipoPerfil, u.imagem
                  ORDER BY u.nomeUsuario ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
?>