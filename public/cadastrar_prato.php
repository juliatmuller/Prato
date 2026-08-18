<?php
require_once "../infra/conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $descricao = trim($_POST["descricao"] ?? "");
    $preco = $_POST["preco"] ?? 0;
    $categoria = trim($_POST["categoria"] ?? "");
    $id_usuario = $_POST["id_usuario"] ?? null;

    if (!empty($nome) && !empty($descricao) && $preco > 0 && !empty($categoria) && !empty($id_usuario)) {
        $stmt = $conexao->prepare("INSERT INTO prato (nome, descricao, preco, categoria, id_usuario) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsi", $nome, $descricao, $preco, $categoria, $id_usuario);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: ../index.php");
exit;