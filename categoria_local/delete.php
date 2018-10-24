<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// Incluindo database e objeto
include_once '../config/database.php';
include_once '../objects/categoria_local.php';
 
// conectando
$database = new Database();
$db = $database->getConnection();
 
// preparando o objeto
$categoria_local = new Categoria_local($db);
 
// conseguindo o id
$dados = json_decode(file_get_contents("php://input"));
 
// setando o id para ser deletado
$categoria_local->id = $dados->id;
 
// deletando
if($categoria_local->delete()){
 
    // setando codigo de resposta - 200 ok
    http_response_code(200);
 
    // enviando mensagem ao usuário
    echo json_encode(array("message" => "Deletado com sucesso"));
}
 
// if unable to delete the product
else{
 
    // setando codigo de resposta - 503 service unavailable
    http_response_code(503);
 
    // enviando mensagem ao usuário
    echo json_encode(array("message" => "Impossível deletar."));
}
?>