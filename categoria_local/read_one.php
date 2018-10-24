<?php
// headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// Banco e Objeto
include_once '../config/database.php';
include_once '../objects/categoria_local.php';
 
// Conectando
$database = new Database();
$db = $database->getConnection();
 
// Objeto
$categoria_local = new Categoria_local($db);
 
// Pegando id
$categoria_local->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// conseguindo detalhes
$categoria_local->readOne();
 
if($categoria_local->nome!=null){
    // criando array
    $categoria_local_arr = array(
        "id" => $categoria_local->id,
        "nome" => $categoria_local->nome,
        "descricao" => $categoria_local->descricao,
        "img" => $categoria_local->img
    );
 
    // mudando codigo de resposta - 200 OK
    http_response_code(200);
 
    // retornando um json
    echo json_encode($categoria_local_arr);
}
 
else{
    // mudando codigo de resposta - 404 Not found
    http_response_code(404);
 
    // mensagem para o usuário
    echo json_encode(array("message" => "O item não existe."));
}
?>