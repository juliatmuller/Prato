<?php
require_once "../infra/conexao.php";

$usuarios = $conexao->query("SELECT * FROM usuario");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Usuários</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <h2>Usuários Cadastrados</h2>
    <a href="../index.php">Voltar</a>
    <table border="1">
        <tr>
            <th>ID</th><th>Nome</th><th>E-mail</th><th>Ação</th>
        </tr>
        <?php while ($usu = $usuarios->fetch_assoc()): ?>
            <tr>
                <td><?php echo $usu['id']; ?></td>
                <td><?php echo $usu['nome']; ?></td>
                <td><?php echo $usu['email']; ?></td>
                <td>
                    <a href="pratos.php?usuario_id=<?php echo $usu['id']; ?>">Ver pratos</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>