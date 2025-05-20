<?php
include "./functions.php";

header("Content-Type: application/json");

try {
    session_start();
    session_unset();
    session_destroy();

    echo createOkayJSON("Sessão finalizada com sucesso");
    exit;
} catch (Exception $err) {
    echo createErrorJSON("Erro ao finalizar a sessão", [ "serverMessage" => $err ]);
    exit;
}