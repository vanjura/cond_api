<?php
// headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// incluindo arquivo necessários
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/categoria_local.php';
 
// instanciando
$database = new Database();
$db = $database->getConnection();
 
// inicializando
$categoria_local = new Categoria_local($db);
 
// conseguindo a pesquisa
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// query
$stmt = $categoria_local->search($keywords);
$num = $stmt->rowCount();
 
// vendo se existe algum registro
if($num>0){
 
    // iniciando aray
    $categoria_local_arr=array();
 
    // conseguindo os dados da tabela
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extraindo a linha
        extract($row);
 
        $categoria_local_item=array(
            "id" => $id,
            "nome" => $nome,
            "descricao" => $descricao,
            "img" => $img
        );
 
        array_push($categoria_local_arr, $categoria_local_item);
    }
 
    // mudando o código de resposta - 200 OK
    http_response_code(200);
 
    // mostrando os dados
    echo json_encode($categoria_local_arr);
}
 
else{
    // mudando o código de resposta - 404 Not found
    http_response_code(404);
 
    // mensagem para o usuário
    echo json_encode(
        array("message" => "Nenhum item encontrado.")
    );
}
?>