<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../configs/Database.php'; 
include_once '../../models/StatusPedido.php';

$database = new Database();
$db = $database->getConnection();

$statusPedido = new StatusPedido($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->idStatus) && 
    !empty($data->descStatus)
) {
    $statusPedido->idStatus = $data->idStatus;
    $statusPedido->descStatus = $data->descStatus;

    if ($statusPedido->create()) {
        http_response_code(201); 
        echo json_encode(array(
            "message" => "Status de pedido criado com sucesso.",
            "idStatus" => $statusPedido->idStatus
        ));
    } else {
        http_response_code(503); 
        echo json_encode(array("message" => "Não foi possível criar o status. O ID já pode existir."));
    }
} else {
    http_response_code(400); 
    echo json_encode(array("message" => "Dados incompletos. 'idStatus' e 'descStatus' são obrigatórios."));
}
?>