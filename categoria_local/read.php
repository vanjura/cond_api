<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// Banco e Objeto
include_once '../config/database.php';
include_once '../objects/categoria_local.php';
 
// Conectando
$database = new Database();
$db = $database->getConnection();
 
// Inicializando o objeto
$categoria_local = new Categoria_local($db);
 
// Executando os comando necessários
$stmt = $categoria_local->read();
$num = $stmt->rowCount();
 
// se houver algum dado
if($num>0){
 
    // setando array
    $arr=array();
 
    // conseguindo dados da tabela
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
 
        $item=array(
            "id" => $id,
            "nome" => $nome,
            "descricao" => $descricao,
            "img" => $img
        );
 
        array_push($arr, $item);
    }
 
    // mudando o código de resposta - 200 OK
    http_response_code(200);
 
    // mostrando os dados recebidos
    echo json_encode($arr);
}
 
else{
 
    // mudando o código de resposta - 404 Not found
    http_response_code(404);
 
    // frase para o usuário
    echo json_encode(
        array("message" => "Nenhum item encontrado.")
    );
}
?>