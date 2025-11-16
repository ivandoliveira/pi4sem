<?php
// Define cabeçalhos para aceitar requisições externas e JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../configs/Database.php'; 
include_once '../../models/TipoPagamento.php';

$database = new Database();
$db = $database->getConnection();

$tipoPagamento = new TipoPagamento($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->idTipoPagto) && 
    !empty($data->descTipoPagto)
) {
    $tipoPagamento->idTipoPagto = $data->idTipoPagto;
    $tipoPagamento->descTipoPagto = $data->descTipoPagto;

    if ($tipoPagamento->create()) {
        http_response_code(201); 
        echo json_encode(array(
            "message" => "Tipo de pagamento criado com sucesso.",
            "idTipoPagto" => $tipoPagamento->idTipoPagto
        ));
    } else {
        http_response_code(503); 
        echo json_encode(array("message" => "Não foi possível criar o tipo de pagamento. O ID já pode existir."));
    }
} else {
    http_response_code(400); 
    echo json_encode(array("message" => "Dados incompletos. 'idTipoPagto' e 'descTipoPagto' são obrigatórios."));
}
?>