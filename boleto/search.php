<?php
// headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// incluindo arquivo necessários
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/condominio.php';
 
// instanciando
$database = new Database();
$db = $database->getConnection();
 
// inicializando
$condominio = new Condominio($db);
 
// conseguindo a pesquisa
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// query
$stmt = $condominio->search($keywords);
$num = $stmt->rowCount();
 
// vendo se existe algum registro
if($num>0){
 
    // iniciando aray
    $condominio_arr=array();
 
    // conseguindo os dados da tabela
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extraindo a linha
        extract($row);
 
        $condominio_item=array(
            "id" => $id,
            "id_morador" => $id_morador,
            "id_banco" => $id_banco,
            "valor" => $valor,
            "data_vencimento" => $data_vencimento,
            "descricao" => $descricao,
            "data_process" => $data_process,
            "cod" => $cod
        );
 
        array_push($condominio_arr, $condominio_item);
    }
 
    // mudando o código de resposta - 200 OK
    http_response_code(200);
 
    // mostrando os dados
    echo json_encode($condominio_arr);
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