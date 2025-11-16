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
include_once '../../models/Cliente.php';

$database = new Database();
$db = $database->getConnection();

$cliente = new Cliente($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->nome) &&
    !empty($data->email) &&
    !empty($data->senha) &&
    !empty($data->cpf)
) {
    $cliente->nomeCompletoCliente = $data->nome;
    $cliente->emailCliente        = $data->email;
    $cliente->senhaCliente        = $data->senha; 
    $cliente->CPFCliente          = $data->cpf;
    
    $cliente->celularCliente      = isset($data->celular) ? $data->celular : null;
    $cliente->telComercialCliente = isset($data->telComercial) ? $data->telComercial : null;
    $cliente->telResidencialCliente = isset($data->telResidencial) ? $data->telResidencial : null;
    $cliente->dtNascCliente       = isset($data->dataNascimento) ? $data->dataNascimento : null;

    if ($cliente->create()) {
        http_response_code(201); 
        echo json_encode(array(
            "message" => "Cliente criado com sucesso.",
            "idCliente" => $cliente->idCliente
        ));
    } else {
        http_response_code(503); 
        echo json_encode(array("message" => "Não foi possível criar o cliente."));
    }
} else {
    http_response_code(400); 
    echo json_encode(array("message" => "Dados obrigatórios (nome, email, senha, cpf) incompletos."));
}
?>