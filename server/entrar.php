<?php
include "./functions.php";
include "../connection.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["email"]) || !isset($_POST["senha"])) {
        echo createErrorJSON("Parâmetros insuficientes para entrar");
        exit;
    }

    $email = $_POST["email"];
    $senha = $_POST["senha"];

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        echo createErrorJSON("E-mail inválido");
        exit;
    }
    if (strlen($senha) < 8) {
        echo createErrorJSON("A senha deve ter pelo menos 8 caracteres");
        exit;
    }

    try {
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            echo createErrorJSON("E-mail não cadastrado");
            exit;
        }
        $usuario = $result->fetch_assoc();
        if (password_verify($senha, $usuario["senha"])) {
            startSession($usuario["nome"], $usuario["email"], $usuario["id"]);
            echo createOkayJSON("Sessão iniciada com sucesso");
            exit;
        } else {
            echo createErrorJSON("Senha incorreta");
            exit;
        }
    } catch (Exception $err) {
        echo createErrorJSON("Erro no banco de dados", [ "serverMessage" => $err ]);
        exit;
    } finally {
        $db->close();
    }
} else {
    echo createErrorJSON("Método não suportado");
    exit;
}