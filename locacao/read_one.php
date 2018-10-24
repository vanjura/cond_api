<?php
// headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// Banco e Objeto
include_once '../config/database.php';
include_once '../objects/locacao.php';
 
// Conectando
$database = new Database();
$db = $database->getConnection();
 
// Objeto
$locacao = new Locacao($db);
 
// Pegando id
$locacao->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// conseguindo detalhes
$locacao->readOne();
 
if($locacao->nome!=null){
    // criando array
    $locacao_arr = array(
        "id" => $locacao->id,
        "id_local" => $locacao->id_local,
        "id_boleto" => $locacao->id_boleto,
        "id_morador" => $locacao->id_morador,
        "data" => $locacao->data,
        "inicio" => $locacao->inicio,
        "fim" => $locacao->fim
    );
 
    // mudando codigo de resposta - 200 OK
    http_response_code(200);
 
    // retornando um json
    echo json_encode($locacao_arr);
}
 
else{
    // mudando codigo de resposta - 404 Not found
    http_response_code(404);
 
    // mensagem para o usuário
    echo json_encode(array("message" => "O item não existe."));
}
?>