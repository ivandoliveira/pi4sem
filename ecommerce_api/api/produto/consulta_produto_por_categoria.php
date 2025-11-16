<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../configs/Database.php'; 
include_once '../../models/Produto.php';

$database = new Database();
$db = $database->getConnection();

$produto = new Produto($db);

$produto->idCategoria = isset($_GET['idCategoria']) ? $_GET['idCategoria'] : die();

$stmt = $produto->consultaProdutosPorCategoria();
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
            "categoria" => array(
                "idCategoria" => $produto->idCategoria,
                "nomeCategoria" => $nomeCategoria
            ),
            "artesao" => array(
                "idUsuario" => $idUsuario,
                "nomeUsuario" => $nomeArtesao
            ),
            "imagem" => $imagem
        );

        array_push($produtos_arr["records"], $produto_item);
    }

    http_response_code(200);
    echo json_encode($produtos_arr);
    
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "Nenhum produto encontrado nesta categoria.")
    );
}
?>