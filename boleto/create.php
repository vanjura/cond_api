<?php
// Headers (não mexer)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// Conseguindo a conexão com o banco e Objeto
include_once '../config/database.php';
include_once '../objects/boleto.php';
 
$database = new Database();
$db = $database->getConnection();
 
$boleto = new Boleto($db);
 
// Conseguindo os dados postados
$dados = json_decode(file_get_contents("php://input"));

// Garantindo que todos os dados obrigatórios foram preenchidos
if(
    !empty($dados->id_morador) &&
    !empty($dados->id_banco) &&
    !empty($dados->valor) &&
    !empty($dados->data_vencimento) &&
    !empty($dados->data_process) &&
    !empty($dados->cod)
){
    // Setando propriedades do objeto
    if(empty($dados->descricao)){
        $dados->descricao = "";
    }
    
    $boleto->id_morador = $dados->id_morador;
    $boleto->id_banco = $dados->id_banco;
    $boleto->valor = $dados->valor;
    $boleto->data_vencimento = $dados->data_vencimento;
    $boleto->descricao = $dados->descricao;
    $boleto->data_process = $dados->data_process;
    $boleto->cod = $dados->cod;


    // Criando
    if($boleto->create()){
 
        // Mudando o código de resposta
        http_response_code(201);
 
        // Informação para o usuário
        echo json_encode(array("message" => "boleto armazenado com sucesso."));
    }
 
    // Se não for possivel criar
    else{
 
        // Mudando o código de resposta
        http_response_code(503);
 
        // Informação para o usuário
        echo json_encode(array("message" => "Impossivel armazenar o boleto."));
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