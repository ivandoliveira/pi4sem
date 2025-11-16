<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../configs/Database.php'; 
include_once '../../models/Categoria.php';

$database = new Database();
$db = $database->getConnection();

$categoria = new Categoria($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->nome)) {
    $categoria->nomeCategoria = $data->nome;
    $categoria->descCategoria = isset($data->descricao) ? $data->descricao : null;

    if ($categoria->create()) {
        http_response_code(201); 
        echo json_encode(array(
            "message" => "Categoria criada com sucesso.",
            "idCategoria" => $categoria->idCategoria
        ));
    } else {
        http_response_code(503); 
        echo json_encode(array("message" => "Não foi possível criar a categoria."));
    }
} else {
    http_response_code(400); 
    echo json_encode(array("message" => "Dados incompletos. 'nome' da categoria é obrigatório."));
}
?>