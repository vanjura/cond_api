<?php
// headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// Banco e Objeto
include_once '../config/database.php';
include_once '../objects/morador.php';
 
// Conectando
$database = new Database();
$db = $database->getConnection();
 
// Objeto
$morador = new Morador($db);
 
// Pegando id
$morador->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// conseguindo detalhes
$morador->readOne();
 
if($morador->nome!=null){
    // criando array
    $morador_arr = array(
        "id" => $morador->id,
        "nome" => $morador->nome,
        "senha" => $morador->senha,
        "email" => $morador->email,
        "is_adm" => $morador->is_adm,
        "avatar" => $morador->avatar
    );
 
    // mudando codigo de resposta - 200 OK
    http_response_code(200);
 
    // retornando um json
    echo json_encode($morador_arr);
}
 
else{
    // mudando codigo de resposta - 404 Not found
    http_response_code(404);
 
    // mensagem para o usuário
    echo json_encode(array("message" => "O item não existe."));
}
?>