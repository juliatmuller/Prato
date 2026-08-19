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
    <form action="atualizar.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $prato['id']; ?>">

        <label>Nome:</label>
        <input type="text" name="nome" value="<?php echo $prato['nome']; ?>" required><br>

        <label>Descrição:</label>
        <input type="text" name="descricao" value="<?php echo $prato['descricao']; ?>" required><br>

        <label>Preço:</label>
        <input type="number" name="preco" step="0.01" value="<?php echo $prato['preco']; ?>" required><br>

       <label>Categoria:</label>

<select name="categoria" required>

    <option value="">Selecione uma categoria</option>

    <option value="entrada" <?php echo ($prato['categoria'] == 'entrada') ? 'selected' : ''; ?>>
        Entrada
    </option>

    <option value="aperitivo" <?php echo ($prato['categoria'] == 'aperitivo') ? 'selected' : ''; ?>>
        Aperitivo
    </option>

    <option value="prato principal" <?php echo ($prato['categoria'] == 'prato principal') ? 'selected' : ''; ?>>
        Prato principal
    </option>

    <option value="sobremesa" <?php echo ($prato['categoria'] == 'sobremesa') ? 'selected' : ''; ?>>
        Sobremesa
    </option>

    <option value="bebida" <?php echo ($prato['categoria'] == 'bebida') ? 'selected' : ''; ?>>
        Bebida
    </option>

    <option value="bebida alcoolizada" <?php echo ($prato['categoria'] == 'bebida alcoolizada') ? 'selected' : ''; ?>>
        Bebida alcoolizada
    </option>

</select>

<br>

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