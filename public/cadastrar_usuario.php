<?php
require_once "../infra/conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if (!empty($nome) && !empty($email)) {
        $stmt = $conexao->prepare("INSERT INTO usuario (nome, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $nome, $email);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: ../index.php");
exit;