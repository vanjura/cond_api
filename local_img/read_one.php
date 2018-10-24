<?php
// headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// Banco e Objeto
include_once '../config/database.php';
include_once '../objects/local_img.php';
 
// Conectando
$database = new Database();
$db = $database->getConnection();
 
// Objeto
$local_img = new Local_img($db);
 
// Pegando id
$local_img->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// conseguindo detalhes
$local_img->readOne();
 
if($local_img->nome!=null){
    // criando array
    $local_img_arr = array(
        "id" => $local_img->id,
        "id_local" => $local_img->id_local,
        "link" => $local_img->link
    );
 
    // mudando codigo de resposta - 200 OK
    http_response_code(200);
 
    // retornando um json
    echo json_encode($local_img_arr);
}
 
else{
    // mudando codigo de resposta - 404 Not found
    http_response_code(404);
 
    // mensagem para o usuário
    echo json_encode(array("message" => "O item não existe."));
}
?>