<?php
// Headers (não mexer)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// Conseguindo a conexão com o banco e Objeto
include_once '../config/database.php';
include_once '../objects/local.php';
 
$database = new Database();
$db = $database->getConnection();
 
$local = new Local($db);
 
// Conseguindo os dados postados
$dados = json_decode(file_get_contents("php://input"));

// Garantindo que todos os dados obrigatórios foram preenchidos
if(
    !empty($dados->id_condominio) &&
    !empty($dados->id_categoria) &&
    !empty($dados->nome) &&
    !empty($dados->preco)
){
    // Setando propriedades do objeto
    if(empty($dados->limite)){
        $dados->limite = -1;
    }
    if(empty($dados->descricao)){
        $dados->descricao = "";
    }
    
    $local->id_condominio = $dados->id_condominio;
    $local->id_categoria = $dados->id_categoria;
    $local->nome = $dados->nome;
    $local->limite = $dados->limite;
    $local->descricao = $dados->descricao;
    $local->preco = $dados->preco;

    // Criando
    if($local->create()){
 
        // Mudando o código de resposta
        http_response_code(201);
 
        // Informação para o usuário
        echo json_encode(array("message" => "local armazenado com sucesso."));
    }
 
    // Se não for possivel criar
    else{
 
        // Mudando o código de resposta
        http_response_code(503);
 
        // Informação para o usuário
        echo json_encode(array("message" => "Impossivel armazenar o local."));
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