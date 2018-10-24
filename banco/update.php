<?php
// headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// incluindo arquivos importantes
include_once '../config/database.php';
include_once '../objects/banco.php';
 
// conectando
$database = new Database();
$db = $database->getConnection();
 
// preparando o objeto
$banco = new Banco($db);
 
// conseguindo o id
$data = json_decode(file_get_contents("php://input"));
 
// setando id para ser atualizado
$banco->id = $data->id;
 
// setando o restante dos valores
$banco->nome = $data->nome;
$banco->agencia = $data->agencia;
$banco->conta = $data->conta;
 
// atualizando
if($banco->update()){
 
    // modificando código de resposta - 200 ok
    http_response_code(200);
 
    // informando o usuário
    echo json_encode(array("message" => "Atualizado com sucesso."));
}
 
else{
 
    // modificando código de resposta - 503 service unavailable
    http_response_code(503);
 
    // informando o usuário
    echo json_encode(array("message" => "Inpossível atualizar esse item."));
}
?>