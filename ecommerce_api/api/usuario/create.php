<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../configs/Database.php';
include_once '../../models/Usuario.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->loginUsuario) &&
    !empty($data->senha) 
) {
    $usuario->loginUsuario = $data->loginUsuario;
    $usuario->senhaUsuario = $data->senha; 
    $usuario->nomeUsuario  = isset($data->nome) ? $data->nome : 'Novo Usuário';
    $usuario->tipoPerfil   = isset($data->perfil) ? $data->perfil : 'C'; 

    if ($usuario->create()) {
        http_response_code(201);
        echo json_encode(array(
            "message" => "Usuário criado com sucesso.",
            "idUsuario" => $usuario->idUsuario
        ));
    } else {
        http_response_code(503); 
        echo json_encode(array("message" => "Não foi possível criar o usuário."));
    }
} else {
    http_response_code(400); 
    echo json_encode(array("message" => "Não foi possível criar o usuário. Dados incompletos."));
}
?>