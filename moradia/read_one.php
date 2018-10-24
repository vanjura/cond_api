<?php
// headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// Banco e Objeto
include_once '../config/database.php';
include_once '../objects/moradia.php';
 
// Conectando
$database = new Database();
$db = $database->getConnection();
 
// Objeto
$moradia = new Moradia($db);
 
// Pegando id
$moradia->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// conseguindo detalhes
$moradia->readOne();
 
if($moradia->nome!=null){
    // criando array
    $moradia_arr = array(
        "id" => $moradia->id,
        "id_condominio" => $moradia->id_condominio,
        "id_morador" => $moradia->id_morador,
        "num" => $moradia->num,
        "tipo" => $moradia->tipo,
        "bloco" => $moradia->bloco
    );
 
    // mudando codigo de resposta - 200 OK
    http_response_code(200);
 
    // retornando um json
    echo json_encode($moradia_arr);
}
 
else{
    // mudando codigo de resposta - 404 Not found
    http_response_code(404);
 
    // mensagem para o usuário
    echo json_encode(array("message" => "O item não existe."));
}
?>