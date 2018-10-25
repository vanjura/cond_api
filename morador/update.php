<?php
// headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// incluindo arquivos importantes
include_once '../config/database.php';
include_once '../objects/morador.php';
 
// conectando
$database = new Database();
$db = $database->getConnection();
 
// preparando o objeto
$morador = new Morador($db);
 
// conseguindo o id
$data = json_decode(file_get_contents("php://input"));
 
// setando id para ser atualizado
$morador->id = $data->id;
 
// setando o restante dos valores
$morador->nome = $data->nome;
$morador->senha = $data->senha;
$morador->email = $data->email;
$morador->is_adm = $data->is_adm;
$morador->avatar = $data->avatar;
$morador->id_condominio = $data->id_condominio;
 
// atualizando
if($morador->update()){
 
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