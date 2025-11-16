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

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->idCliente) && 
    !empty($data->idTipoPagto) &&
    !empty($data->idAplicacao) &&
    !empty($data->itens) &&
    is_array($data->itens)
) {
    $pedido->idCliente   = $data->idCliente;
    $pedido->idTipoPagto = $data->idTipoPagto;
    $pedido->idAplicacao = $data->idAplicacao;
    
    $pedido->idStatus = isset($data->idStatus) ? $data->idStatus : 1; 

    $pedido->idEndereco = isset($data->idEndereco) ? $data->idEndereco : null;

    $pedido->itens = $data->itens; 

    if ($pedido->createTransaction()) {
        http_response_code(201);
        echo json_encode(array(
            "message" => "Pedido e itens cadastrados com sucesso.",
            "idPedido" => $pedido->idPedido
        ));
    } else {
        http_response_code(503); 
        echo json_encode(array("message" => "Não foi possível cadastrar o pedido. Possível erro de FK ou item inválido."));
    }
} else {
    http_response_code(400); 
    echo json_encode(array("message" => "Dados obrigatórios (idCliente, idTipoPagto, idAplicacao, itens) incompletos ou inválidos."));
}
?>