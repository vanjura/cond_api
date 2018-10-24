<?php
// Headers (não mexer)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// Conseguindo a conexão com o banco e Objeto
include_once '../config/database.php';
include_once '../objects/locacao.php';
 
$database = new Database();
$db = $database->getConnection();
 
$locacao = new Locacao($db);
 
// Conseguindo os dados postados
$dados = json_decode(file_get_contents("php://input"));

// Garantindo que todos os dados obrigatórios foram preenchidos
if(
    !empty($dados->id_local) &&
    !empty($dados->id_boleto) &&
    !empty($dados->id_morador) &&
    !empty($dados->data) &&
    !empty($dados->inicio) &&
    !empty($dados->fim)
){
    // Setando propriedades do objeto    
    $locacao->id_local = $dados->id_local;
    $locacao->id_boleto = $dados->id_boleto;
    $locacao->id_morador = $dados->id_morador;
    $locacao->data = $dados->data;
    $locacao->inicio = $dados->inicio;
    $locacao->fim = $dados->fim;


    // Criando
    if($locacao->create()){
 
        // Mudando o código de resposta
        http_response_code(201);
 
        // Informação para o usuário
        echo json_encode(array("message" => "locacao armazenado com sucesso."));
    }
 
    // Se não for possivel criar
    else{
 
        // Mudando o código de resposta
        http_response_code(503);
 
        // Informação para o usuário
        echo json_encode(array("message" => "Impossivel armazenar o locacao."));
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