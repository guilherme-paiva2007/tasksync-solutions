<?php

include "./crud_tarefas.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo createErrorJSON("Método não suportado");
    exit;
}

$action = "GET";

if (isset($_POST["action"])) {
    $action = $_POST["action"];
}

try {
    $result = crud_tarefas($action, $_POST);
    echo createOkayJSON("Operação realizada com sucesso", [ "result" => $result ]);
    exit;
} catch (Exception $err) {
    echo createErrorJSON("Erro ao processar a requisição", [ "serverMessage" => $err ]);
    exit;
}