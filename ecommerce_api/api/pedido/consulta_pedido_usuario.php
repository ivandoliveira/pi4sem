<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Origin: *"); 
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}


include_once '../../configs/Database.php'; 
include_once '../../models/Pedido.php';

$database = new Database();
$db = $database->getConnection();

$pedido = new Pedido($db);

$idCliente = isset($_GET['idCliente']) ? $_GET['idCliente'] : null;

if (empty($idCliente)) {
    http_response_code(400);
    echo json_encode(array("message" => "Parâmetro idCliente é obrigatório."));
    die();
}

$pedido->idCliente = $idCliente;

$pedidos_data = $pedido->consultaPedidosPorCliente();

if ($pedidos_data && count($pedidos_data) > 0) {
    $pedidos_arr = array();

    foreach ($pedidos_data as $p) {
        $itens_arr = array();

        if (isset($p['itens']) && count($p['itens']) > 0) {
            foreach ($p['itens'] as $item) {
                $itens_arr[] = array(
                    "idProduto" => (int)$item['idProduto'],
                    "nomeProduto" => $item['nomeProduto'],
                    "descProduto" => $item['descProduto'],
                    "qtdProduto" => (int)$item['qtdProduto'],
                    "precoVendaItem" => (float)$item['precoVendaItem']
                );
            }
        }

        $pedidos_arr[] = array(
            "idPedido" => (int)$p['idPedido'],
            "idCliente" => (int)$idCliente,
            "dataPedido" => $p['dataPedido'],
            "status" => $p['status'],
            "tipoPagamento" => $p['tipoPagamento'],
            "aplicacao" => array(
                "descricao" => $p['aplicacaoDescricao'],
                "tipo" => $p['aplicacaoTipo']
            ),
            "enderecoEntrega" => array(
                "logradouro" => $p['logradouro'],
                "numero" => $p['numero'],
                "cep" => $p['cep']
            ),
            "itens" => $itens_arr,
            "totalItens" => count($itens_arr)
        );
    }

    http_response_code(200);
    echo json_encode($pedidos_arr);

} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "Nenhum pedido encontrado para este cliente.")
    );
}
?>
