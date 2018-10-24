<?php
// headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// Banco e Objeto
include_once '../config/database.php';
include_once '../objects/condominio.php';
 
// Conectando
$database = new Database();
$db = $database->getConnection();
 
// Objeto
$condominio = new Condominio($db);
 
// Pegando id
$condominio->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// conseguindo detalhes
$condominio->readOne();
 
if($condominio->nome!=null){
    // criando array
    $condominio_arr = array(
        "id" => $condominio->id,
        "id_morador" => $condominio->id_morador,
        "logo" => $condominio->logo,
        "nome" => $condominio->nome,
        "rua" => $condominio->rua,
        "num" => $condominio->num,
        "cidade" => $condominio->cidade,
        "uf" => $condominio->uf,
        "cnpj" => $condominio->cnpj
    );
 
    // mudando codigo de resposta - 200 OK
    http_response_code(200);
 
    // retornando um json
    echo json_encode($condominio_arr);
}
 
else{
    // mudando codigo de resposta - 404 Not found
    http_response_code(404);
 
    // mensagem para o usuário
    echo json_encode(array("message" => "O item não existe."));
}
?>