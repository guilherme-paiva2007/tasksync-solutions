<?php
include "./functions.php";
include "../connection.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"]) {
    if (!isset($_POST["nome"]) || !isset($_POST["email"]) || !isset($_POST["senha"])) {
        echo createErrorJSON("Parâmetros insuficientes para cadastrar");      
        exit;
    }

    $nome = $_POST["nome"];
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

    $senha = password_hash($senha, PASSWORD_DEFAULT);

    try {
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo createErrorJSON("E-mail já cadastrado");
            exit;
        }

        $stmt = $db->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $senha);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            startSession($nome, $email, $stmt->insert_id);
            echo createOkayJSON("Usuário criado com sucesso");
            exit;
        } else {
            echo createErrorJSON("Erro ao cadastrar o usuário");
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