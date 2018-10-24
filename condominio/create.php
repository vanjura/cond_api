<?php
// Headers (não mexer)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// Conseguindo a conexão com o banco e Objeto
include_once '../config/database.php';
include_once '../objects/condominio.php';
 
$database = new Database();
$db = $database->getConnection();
 
$condominio = new Condominio($db);
 
// Conseguindo os dados postados
$dados = json_decode(file_get_contents("php://input"));

// Garantindo que todos os dados obrigatórios foram preenchidos
if(
    !empty($dados->nome) &&
    !empty($dados->rua) &&
    !empty($dados->num) &&
    !empty($dados->cidade) &&
    !empty($dados->uf) &&
    !empty($dados->cnpj)
){
    // Setando propriedades do objeto
    if(empty($dados->logo)){
        $dados->logo = 1;
    }
    if(empty($dados->id_morador)){
        $dados->id_morador = 0;
    }
    
    $condominio->id_morador = $dados->id_morador;
    $condominio->logo = $dados->logo;
    $condominio->nome = $dados->nome;
    $condominio->rua = $dados->rua;
    $condominio->num = $dados->num;
    $condominio->cidade = $dados->cidade;
    $condominio->uf = $dados->uf;
    $condominio->cnpj = $dados->cnpj;


    // Criando
    if($condominio->create()){
 
        // Mudando o código de resposta
        http_response_code(201);
 
        // Informação para o usuário
        echo json_encode(array("message" => "Condominio armazenado com sucesso."));
    }
 
    // Se não for possivel criar
    else{
 
        // Mudando o código de resposta
        http_response_code(503);
 
        // Informação para o usuário
        echo json_encode(array("message" => "Impossivel armazenar o condominio."));
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