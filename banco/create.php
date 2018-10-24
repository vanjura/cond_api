<?php
// Headers (não mexer)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// Conseguindo a conexão com o banco e Objeto
include_once '../config/database.php';
include_once '../objects/banco.php';
 
$database = new Database();
$db = $database->getConnection();
 
$banco = new Banco($db);
 
// Conseguindo os dados postados
$dados = json_decode(file_get_contents("php://input"));

// Garantindo que todos os dados obrigatórios foram preenchidos
if(
    !empty($dados->nome) &&
    !empty($dados->agencia) &&
    !empty($dados->conta)
){
    // Setando propriedades do objeto
    $banco->nome = $dados->nome;
    $banco->agencia = $dados->agencia;
    $banco->conta = $dados->conta;


    // Criando
    if($banco->create()){
 
        // Mudando o código de resposta
        http_response_code(201);
 
        // Informação para o usuário
        echo json_encode(array("message" => "Banco armazenado com sucesso."));
    }
 
    // Se não for possivel criar
    else{
 
        // Mudando o código de resposta
        http_response_code(503);
 
        // Informação para o usuário
        echo json_encode(array("message" => "Impossivel armazenar o banco."));
    }
}
 
// Se os dados não estiverem completos
else{
 
    // Mudando o código de resposta
    http_response_code(400);
 
    // Informação para o usuário
    echo json_encode(array("message" => "Impossivel criar. Estão faltando dados."));
}
?>