<?php
// headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// incluindo arquivo necessários
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/moradia.php';
 
// instanciando
$database = new Database();
$db = $database->getConnection();
 
// inicializando
$moradia = new Moradia($db);
 
// conseguindo a pesquisa
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// query
$stmt = $moradia->search($keywords);
$num = $stmt->rowCount();
 
// vendo se existe algum registro
if($num>0){
 
    // iniciando aray
    $moradia_arr=array();
 
    // conseguindo os dados da tabela
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extraindo a linha
        extract($row);
 
        $moradia_item=array(
            "id" => $id,
            "id_condominio" => $id_condominio,
            "id_morador" => $id_morador,
            "num" => $num,
            "tipo" => $tipo,
            "bloco" => $bloco
        );
 
        array_push($moradia_arr, $moradia_item);
    }
 
    // mudando o código de resposta - 200 OK
    http_response_code(200);
 
    // mostrando os dados
    echo json_encode($moradia_arr);
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