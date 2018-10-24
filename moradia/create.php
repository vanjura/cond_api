<?php
// Headers (não mexer)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// Conseguindo a conexão com o banco e Objeto
include_once '../config/database.php';
include_once '../objects/moradia.php';
 
$database = new Database();
$db = $database->getConnection();
 
$moradia = new Moradia($db);
 
// Conseguindo os dados postados
$dados = json_decode(file_get_contents("php://input"));

// Garantindo que todos os dados obrigatórios foram preenchidos
if(
    !empty($dados->id_moradia) &&
    !empty($dados->num)
){
    // Setando propriedades do objeto
    if(empty($dados->id_morador)){
        $dados->id_morador = -1;
    }
    if(empty($dados->tipo)){
        $dados->tipo = "";
    }
    if(empty($dados->bloco)){
        $dados->bloco = "";
    }

    $moradia->id_moradia = $dados->id_moradia;
    $moradia->id_morador = $dados->id_morador;
    $moradia->num = $dados->num;
    $moradia->tipo = $dados->tipo;
    $moradia->bloco = $dados->bloco;


    // Criando
    if($moradia->create()){
 
        // Mudando o código de resposta
        http_response_code(201);
 
        // Informação para o usuário
        echo json_encode(array("message" => "moradia armazenado com sucesso."));
    }
 
    // Se não for possivel criar
    else{
 
        // Mudando o código de resposta
        http_response_code(503);
 
        // Informação para o usuário
        echo json_encode(array("message" => "Impossivel armazenar o moradia."));
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