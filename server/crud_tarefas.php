<?php
error_reporting(0);
ini_set('display_errors', 0);
if (!isset($functionIncluded)) include "./functions.php";
include "../connection.php";

session_start();

function crud_tarefas($method, $params = []) {
    global $db;
    switch ($method) {
        case "POST":
            if (
                !isset($params["descricao"]) ||
                !isset($params["setor"]) ||
                !isset($params["prioridade"]) ||
                !isset($params["status"])
            ) {
                throw new Exception("Parâmetros faltando");
            }

            $descricao = $params["descricao"];
            $setor = $params["setor"];
            $prioridade = $params["prioridade"];
            $status = $params["status"];

            if (!in_array($prioridade, [ "baixa", "media", "alta" ])) {
                throw new Exception("Prioridade inválida");
            }
            if (!in_array($status, [ "a fazer", "fazendo", "concluido" ])) {
                throw new Exception("Status inválido");
            }
            
            $stmt = $db->prepare("INSERT INTO tarefas (id_usuario, descricao, setor, prioridade, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $_SESSION["id"], $descricao, $setor, $prioridade, $status);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                return [
                    "id" => $stmt->insert_id,
                    "id_usuario" => $_SESSION["id"],
                    "descricao" => $descricao,
                    "setor" => $setor,
                    "prioridade" => $prioridade,
                    "status" => $status,
                ];
            } else {
                throw new Exception("Erro ao cadastrar a tarefa");
            }
        case "GET":
            $usuario_id = $_SESSION["id"];
            if (isset($params["id"])) {
                $id = $params["id"];
                if (!is_numeric($id)) {
                    throw new Exception("ID inválido");
                }

                $stmt = $db->prepare("SELECT * FROM tarefas WHERE id_usuario = ? AND id = ?");
                $stmt->bind_param("ii", $usuario_id, $id);
                $stmt->execute();

                $tarefas = [
                    "a fazer" => [],
                    "fazendo" => [],
                    "concluido" => []
                ];

                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    array_push($tarefas[$row["status"]], [
                        "id" => $row["id"],
                        "descricao" => $row["descricao"],
                        "setor" => $row["setor"],
                        "prioridade" => $row["prioridade"],
                        "data" => $row["data"],
                        "status" => $row["status"]
                    ]);
                }

                return $tarefas;
            } else {
                $stmt = $db->prepare("SELECT * FROM tarefas WHERE id_usuario = ?");
                $stmt->bind_param("i", $usuario_id);
                $stmt->execute();

                $tarefas = [
                    "a fazer" => [],
                    "fazendo" => [],
                    "concluido" => []
                ];

                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    array_push($tarefas[$row["status"]], [
                        "id" => $row["id"],
                        "descricao" => $row["descricao"],
                        "setor" => $row["setor"],
                        "prioridade" => $row["prioridade"],
                        "data" => $row["data"],
                        "status" => $row["status"]
                    ]);
                }

                return $tarefas;
            }
        default:
            throw new Exception("Método não suportado");
    }
}