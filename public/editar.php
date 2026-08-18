<?php
require_once "../infra/conexao.php";

$id = $_GET["id"] ?? null;

if (!$id) {
    header("Location: ../index.php");
    exit;
}

$stmt = $conexao->prepare("SELECT * FROM prato WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$prato = $stmt->get_result()->fetch_assoc();
$stmt->close();

$usuarios = $conexao->query("SELECT * FROM usuario");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Prato</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <h2>Editar Prato</h2>
    <form action="prato_atualizar.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $prato['id']; ?>">

        <label>Nome:</label>
        <input type="text" name="nome" value="<?php echo $prato['nome']; ?>" required><br>

        <label>Descrição:</label>
        <input type="text" name="descricao" value="<?php echo $prato['descricao']; ?>" required><br>

        <label>Preço:</label>
        <input type="number" name="preco" step="0.01" value="<?php echo $prato['preco']; ?>" required><br>

        <label>Categoria:</label>
        <input type="text" name="categoria" value="<?php echo $prato['categoria']; ?>" required><br>

        <label>Usuário responsável:</label>
        <select name="id_usuario" required>
            <?php while ($usu = $usuarios->fetch_assoc()): ?>
                <option value="<?php echo $usu['id']; ?>" <?php echo ($usu['id'] == $prato['id_usuario']) ? 'selected' : ''; ?>>
                    <?php echo $usu['nome']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>