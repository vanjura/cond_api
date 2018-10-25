<?php
// Headers (não mexer)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// Conseguindo a conexão com o banco e Objeto
include_once '../config/database.php';
include_once '../objects/morador.php';
 
$database = new Database();
$db = $database->getConnection();
 
$morador = new Morador($db);
 
// Conseguindo os dados postados
$dados = json_decode(file_get_contents("php://input"));

// Garantindo que todos os dados obrigatórios foram preenchidos
if(
    !empty($dados->nome) &&
    !empty($dados->senha) &&
    !empty($dados->email) &&
    !empty($dados->id_condominio)
){
    if(empty($dados->is_adm)){
        $dados->is_adm = 0;
    }
    if(empty($dados->avatar)){
        $dados->avatar = 1;
    }
    // Setando propriedades do objeto
    $morador->nome = $dados->nome;
    $morador->senha = $dados->senha;
    $morador->email = $dados->email;
    $morador->is_adm = $dados->is_adm;
    $morador->avatar = $dados->avatar;
    $morador->id_condominio = $dados->id_condominio;
 
    // Criando
    if($morador->create()){
 
        // Mudando o código de resposta
        http_response_code(201);
 
        // Informação para o usuário
        echo json_encode(array("message" => "Morador armazenado com sucesso."));
    }
 
    // Se não for possivel criar
    else{
 
        // Mudando o código de resposta
        http_response_code(503);
 
        // Informação para o usuário
        echo json_encode(array("message" => "Impossivel armazenar o Morador."));
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