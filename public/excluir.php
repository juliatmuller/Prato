<?php
require_once "../infra/conexao.php";

$id = $_GET["id"] ?? null;

if ($id) {
    $stmt = $conexao->prepare("DELETE FROM prato WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: ../index.php");
exit;