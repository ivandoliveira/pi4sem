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
include_once '../../models/Produto.php';

$database = new Database();
$db = $database->getConnection();

$produto = new Produto($db);

$stmt = $produto->consultaTodosOsProdutos();
$num = $stmt->rowCount();

if($num > 0){
    $produtos_arr = array();
    $produtos_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $produto_item = array(
            "idProduto" => $idProduto,
            "nomeProduto" => $nomeProduto,
            "descProduto" => html_entity_decode($descProduto),
            "precProduto" => (float)$precProduto,
            "descontoPromocao" => (float)$descontoPromocao,
            "ativoProduto" => $ativoProduto,
            "imagem" => $imagem,
            "categoria" => array(
                "nome" => $nomeCategoria
            ),
            "artesao" => array(
                "idUsuario" => $idUsuario,
                "nome" => $nomeArtesao
            )
        );

        array_push($produtos_arr["records"], $produto_item);
    }

    http_response_code(200);
    echo json_encode($produtos_arr);
    
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "Nenhum produto encontrado.")
    );
}
?>