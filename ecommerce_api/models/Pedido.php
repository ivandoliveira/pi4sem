<?php
class Pedido {
    private $conn;
    private $table_name = "Pedido";

    public $idPedido;
    public $idCliente;
    public $idStatus;
    public $dataPedido;
    public $idTipoPagto;
    public $idEndereco;
    public $idAplicacao;
    
    public $itens; 

    public function __construct($db){
        $this->conn = $db;
    }

    function createTransaction(){
        try {
            $this->conn->beginTransaction();

            if (!$this->insertPedido()) {
                $this->conn->rollBack();
                return false;
            }

            if (!$this->insertItens()) {
                $this->conn->rollBack();
                return false;
            }

            $this->conn->commit();
            return true;

        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Erro na transação de pedido: " . $e->getMessage()); 
            return false;
        }
    }


    private function insertPedido(){
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    idCliente = :idCliente,
                    idStatus = :idStatus,
                    dataPedido = :dataPedido,
                    idTipoPagto = :idTipoPagto,
                    idEndereco = :idEndereco,
                    idAplicacao = :idAplicacao";

        $stmt = $this->conn->prepare($query);

        $this->dataPedido = date('Y-m-d H:i:s');
        
        $stmt->bindParam(":idCliente", $this->idCliente);
        $stmt->bindParam(":idStatus", $this->idStatus);
        $stmt->bindParam(":dataPedido", $this->dataPedido);
        $stmt->bindParam(":idTipoPagto", $this->idTipoPagto);
        $stmt->bindParam(":idEndereco", $this->idEndereco);
        $stmt->bindParam(":idAplicacao", $this->idAplicacao);

        if ($stmt->execute()) {
            $this->idPedido = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }
    
    private function insertItens(){
        $query = "INSERT INTO ItemPedido 
                SET
                    idProduto = :idProduto,
                    idPedido = :idPedido,
                    qtdProduto = :qtdProduto,
                    precoVendaItem = :precoVendaItem";

        foreach ($this->itens as $item) {
            $stmt = $this->conn->prepare($query);

            $idProduto = htmlspecialchars(strip_tags($item->idProduto));
            $qtdProduto = htmlspecialchars(strip_tags($item->qtdProduto));
            $precoVendaItem = htmlspecialchars(strip_tags($item->precoVendaItem));
            
            $stmt->bindParam(":idProduto", $idProduto);
            $stmt->bindParam(":idPedido", $this->idPedido); 
            $stmt->bindParam(":qtdProduto", $qtdProduto);
            $stmt->bindParam(":precoVendaItem", $precoVendaItem);

            if (!$stmt->execute()) {
                return false; 
            }
        }
        return true;
    }


        // Retorna todos os pedidos de um cliente
    function consultaPedidosPorCliente() {
        $query = "SELECT 
                    p.idPedido, p.dataPedido, 
                    s.descStatus AS status, 
                    tp.descTipoPagto AS tipoPagamento,
                    a.DescAplicacao AS aplicacaoDescricao, 
                    a.TipoAplicacao AS aplicacaoTipo,
                    e.logradouroEndereco AS logradouro,
                    e.numeroEndereco AS numero,
                    e.CEPEndereco AS cep
                FROM " . $this->table_name . " p
                LEFT JOIN StatusPedido s ON p.idStatus = s.idStatus
                LEFT JOIN TipoPagamento tp ON p.idTipoPagto = tp.idTipoPagto
                LEFT JOIN Aplicacao a ON p.idAplicacao = a.idAplicacao
                LEFT JOIN Endereco e ON p.idEndereco = e.idEndereco
                WHERE p.idCliente = :idCliente
                ORDER BY p.dataPedido DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idCliente', $this->idCliente);
        $stmt->execute();

        $pedidos = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Pega os itens do pedido
            $this->idPedido = $row['idPedido'];
            $itensStmt = $this->readItems();
            $itens = $itensStmt->fetchAll(PDO::FETCH_ASSOC);

            $row['itens'] = $itens;
            $pedidos[] = $row;
        }

        return $pedidos;
    }



    function readItems(){
        $query = "SELECT 
                    ip.idProduto, ip.qtdProduto, ip.precoVendaItem, 
                    prod.nomeProduto, prod.descProduto
                  FROM ItemPedido ip
                  LEFT JOIN Produto prod ON ip.idProduto = prod.idProduto
                  WHERE ip.idPedido = :idPedido";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idPedido', $this->idPedido);
        $stmt->execute();

        return $stmt;
    }
    
}
?>