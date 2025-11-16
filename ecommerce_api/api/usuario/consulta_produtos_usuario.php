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
include_once '../../models/Usuario.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

$stmt = $usuario->consultaProdutosDoVendedor();
$num = $stmt->rowCount();

if($num > 0){
    $usuarios_arr = array();
    $usuarios_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $usuario_item = array(
            "idUsuario" => $idUsuario,
            "nomeUsuario" => $nomeUsuario,
            "loginUsuario" => $loginUsuario,
            "tipoPerfil" => $tipoPerfil,
            "imagem" => $imagem,
            "total_produtos" => (int)$total_produtos 
        );

        array_push($usuarios_arr["records"], $usuario_item);
    }

    http_response_code(200);
    echo json_encode($usuarios_arr);
    
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "Nenhum usuário encontrado.")
    );
}
?>