<?php
// headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// Banco e Objeto
include_once '../config/database.php';
include_once '../objects/boleto.php';
 
// Conectando
$database = new Database();
$db = $database->getConnection();
 
// Objeto
$boleto = new Boleto($db);
 
// Pegando id
$boleto->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// conseguindo detalhes
$boleto->readOne();
 
if($boleto->nome!=null){
    // criando array
    $boleto_arr = array(
        "id" => $boleto->id,
        "id_morador" => $boleto->id_morador,
        "id_banco" => $boleto->id_banco,
        "valor" => $boleto->valor,
        "data_vencimento" => $boleto->data_vencimento,
        "descricao" => $boleto->descricao,
        "data_process" => $boleto->data_process,
        "cod" => $boleto->cod
    );
 
    // mudando codigo de resposta - 200 OK
    http_response_code(200);
 
    // retornando um json
    echo json_encode($boleto_arr);
}
 
else{
    // mudando codigo de resposta - 404 Not found
    http_response_code(404);
 
    // mensagem para o usuário
    echo json_encode(array("message" => "O item não existe."));
}
?>