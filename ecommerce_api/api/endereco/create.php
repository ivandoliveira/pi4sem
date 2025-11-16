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
include_once '../../models/Endereco.php';

$database = new Database();
$db = $database->getConnection();

$endereco = new Endereco($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->idCliente) && 
    !empty($data->nomeEndereco) &&
    !empty($data->logradouro) &&
    !empty($data->numero) &&
    !empty($data->cep) &&
    !empty($data->cidade) 
) {
    $endereco->idCliente = $data->idCliente; 

    $endereco->nomeEndereco       = $data->nomeEndereco;
    $endereco->logradouroEndereco = $data->logradouro;
    $endereco->numeroEndereco     = $data->numero;
    $endereco->CEPEndereco        = $data->cep;
    $endereco->cidadeEndereco     = $data->cidade;
    
    $endereco->complementoEndereco = isset($data->complemento) ? $data->complemento : null;
    $endereco->paisEndereco        = isset($data->pais) ? $data->pais : "Brasil"; 
    $endereco->UFEndereco          = isset($data->uf) ? $data->uf : null;
    $endereco->imagem              = isset($data->imagem) ? $data->imagem : null;

    if ($endereco->create()) {
        http_response_code(201); 
        echo json_encode(array(
            "message" => "Endereço criado com sucesso.",
            "idEndereco" => $endereco->idEndereco
        ));
    } else {
        http_response_code(503); 
        echo json_encode(array("message" => "Não foi possível criar o endereço."));
    }
} else {
    http_response_code(400); 
    echo json_encode(array("message" => "Dados obrigatórios (idCliente, nomeEndereco, logradouro, numero, cep, cidade) incompletos."));
}
?>