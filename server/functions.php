<?php
$functionIncluded = true;

function createOkayJSON($message, $otherParams = []) {
    $json = [
        "status" => "okay",
        "message" => $message
    ];
    foreach ($otherParams as $key => $value) {
        $json[$key] = $value;
    }
    return json_encode($json, JSON_UNESCAPED_UNICODE);
}

function createErrorJSON($message, $otherParams = []) {
    $json = [
        "status" => "error",
        "message" => $message
    ];
    foreach ($otherParams as $key => $value) {
        $json[$key] = $value;
    }
    if (isset($otherParams["code"])) {
        http_response_code($otherParams["code"]);
    } else {
        http_response_code(400);
    }
    return json_encode($json, JSON_UNESCAPED_UNICODE);
}
function startSession($nome, $email, $id) {
    session_start();
    $_SESSION["nome"] = $nome;
    $_SESSION["email"] = $email;
    $_SESSION["id"] = $id;
}