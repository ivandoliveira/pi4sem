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
    !empty($data->email) &&
    !empty($data->senha)
) {
    $emailCliente = $data->email;
    $senhaCliente = $data->senha; 

    $clienteAutenticado = $cliente->login($emailCliente, $senhaCliente);

    if ($clienteAutenticado !== false) {
        http_response_code(200); 
        
        unset($clienteAutenticado->senhaCliente); 

        echo json_encode(array(
            "sucesso" => true,
            "message" => "Login realizado com sucesso.",
            "cliente" => $clienteAutenticado
        ), JSON_UNESCAPED_UNICODE);

    }
} else {
    http_response_code(400); 
    echo json_encode(array(
        "sucesso" => false,
        "message" => "Dados obrigatórios (email, senha) incompletos."
    ), JSON_UNESCAPED_UNICODE);
}
?>