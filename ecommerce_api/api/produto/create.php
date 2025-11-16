<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../configs/Database.php'; 
include_once '../../models/Produto.php';

$database = new Database();
$db = $database->getConnection();

$produto = new Produto($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->nomeProduto) && 
    !empty($data->precProduto) &&
    !empty($data->idCategoria) && 
    !empty($data->idUsuario)
) {
    $produto->nomeProduto    = $data->nomeProduto;
    $produto->precProduto    = $data->precProduto; 
    $produto->idCategoria    = $data->idCategoria;
    $produto->idUsuario      = $data->idUsuario;
    
    $produto->descProduto      = isset($data->descProduto) ? $data->descProduto : null;
    $produto->descontoPromocao = isset($data->descontoPromocao) ? $data->descontoPromocao : null;
    $produto->qtdMinEstoque    = isset($data->qtdMinEstoque) ? $data->qtdMinEstoque : null;
    $produto->imagem           = isset($data->imagem) ? $data->imagem : null;
    $produto->ativoProduto     = isset($data->ativoProduto) ? $data->ativoProduto : 'S'; 

    if ($produto->create()) {
        http_response_code(201);
        echo json_encode(array(
            "message" => "Produto criado com sucesso.",
            "idProduto" => $produto->idProduto
        ));
    } else {
        http_response_code(503); 
        echo json_encode(array("message" => "Não foi possível criar o produto. Verifique se o idUsuario e idCategoria são válidos."));
    }
} else {
    http_response_code(400); 
    echo json_encode(array("message" => "Dados obrigatórios (nomeProduto, precProduto, idCategoria, idUsuario) incompletos."));
}
?>