<?php
// headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// Banco e Objeto
include_once '../config/database.php';
include_once '../objects/imagens.php';
 
// Conectando
$database = new Database();
$db = $database->getConnection();
 
// Objeto
$imagens = new Imagens($db);
 
// Pegando id
$imagens->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// conseguindo detalhes
$imagens->readOne();
 
if($imagens->nome!=null){
    // criando array
    $imagens_arr = array(
        "id" => $imagens->id,
        "link" => $imagens->link,
        "nome" => $imagens->nome
    );
 
    // mudando codigo de resposta - 200 OK
    http_response_code(200);
 
    // retornando um json
    echo json_encode($imagens_arr);
}
 
else{
    // mudando codigo de resposta - 404 Not found
    http_response_code(404);
 
    // mensagem para o usuário
    echo json_encode(array("message" => "O item não existe."));
}
?>