<?php

include "infra/conexao.php";

$filtro_usuario = $_GET['usuario_id'] ?? null;

if ($filtro_usuario) {
    $stmt = $conexao->prepare("
        SELECT prato.*, usuario.nome AS usuario_nome
        FROM prato
        INNER JOIN usuario ON prato.id_usuario = usuario.id
        WHERE prato.id_usuario = ?
    ");
    $stmt->bind_param("i", $filtro_usuario);
    $stmt->execute();
    $pratos = $stmt->get_result();
} else {
    $sql = "SELECT prato.*, usuario.nome AS usuario_nome
            FROM prato
            INNER JOIN usuario ON prato.id_usuario = usuario.id";
    $pratos = mysqli_query($conexao, $sql);
}

$usuarios_prato = mysqli_query($conexao, "SELECT id, nome FROM usuario ORDER BY nome");
$usuarios_filtro = mysqli_query($conexao, "SELECT id, nome FROM usuario ORDER BY nome");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Restaurante</title>
   <link rel="stylesheet" href="style/style.css?v=2">
</head>

<body>

    <header>
        <h1>CRUD - Restaurante</h1>
      
    </header>

    <main>

        <h2>Cadastrar Usuário</h2>

        <form action="public/cadastrar_usuario.php" method="POST">

            <label for="nome_usuario">Nome:</label>
            <input type="text" id="nome_usuario" name="nome" required>

            <br>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <br>

            <button type="submit">Cadastrar Usuário</button>

        </form>

        <h2>Adicionar um novo prato!</h2>

        <form action="public/cadastrar_prato.php" method="POST">

            <label for="nome_prato">Nome do prato:</label>
            <input type="text" id="nome_prato" name="nome" required>

            <br>

            <label for="descricao">Descrição:</label>
            <input type="text" id="descricao" name="descricao" required>

            <br>

            <label for="preco">Preço:</label>
            <input type="number" id="preco" name="preco" step="0.01" required>

            <br>

          <label for="categoria">Categoria:</label>

<select id="categoria" name="categoria" required>
    <option value="">Selecione uma categoria</option>
    <option value="entrada">Entrada</option>
    <option value="aperitivo">Aperitivo</option>
    <option value="prato principal">Prato principal</option>
    <option value="sobremesa">Sobremesa</option>
    <option value="bebida">Bebida</option>
    <option value="bebida alcoolizada">Bebida alcoolizada</option>
</select>
            <br>

          <label for="id_usuario">Usuário responsável:</label>

<select id="id_usuario" name="id_usuario" required>
    <option value="">Selecione um usuário</option>

    <?php while ($usuario = mysqli_fetch_assoc($usuarios_prato)) { ?>
        <option value="<?php echo $usuario['id']; ?>">
            <?php echo htmlspecialchars($usuario['nome']); ?>
        </option>
    <?php } ?>

</select>

            <br>

            <button type="submit">Cadastrar Prato</button>

        </form>

        <div>

<h2>Pratos Cadastrados</h2>

<form action="index.php" method="GET">
    <label for="filtro_usuario">Filtrar por Usuário:</label>

    <select name="usuario_id" id="filtro_usuario" onchange="this.form.submit()">
        <option value="">Todos os usuários</option>

        <?php while ($u = mysqli_fetch_assoc($usuarios_filtro)) { ?>

            <option value="<?php echo $u['id']; ?>"
                <?php echo ($filtro_usuario == $u['id']) ? 'selected' : ''; ?>>
                <?php echo $u['nome']; ?>
            </option>

        <?php } ?>

    </select>
</form>

<br>

<table border="1">

    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Preço</th>
        <th>Categoria</th>
        <th>Cadastrado por</th>
        <th>Ação</th>
    </tr>

    <?php while ($prato = mysqli_fetch_assoc($pratos)) { ?>

        <tr>

            <td><?php echo $prato["id"]; ?></td>

            <td><?php echo $prato["nome"]; ?></td>

            <td><?php echo $prato["descricao"]; ?></td>

            <td>
                R$ <?php echo number_format($prato["preco"], 2, ',', '.'); ?>
            </td>

            <td><?php echo $prato["categoria"]; ?></td>

            <td><?php echo $prato["usuario_nome"]; ?></td>

            <td>
                <a href="public/editar.php?id=<?php echo $prato["id"]; ?>">
                    Editar
                </a>

                <a href="public/excluir.php?id=<?php echo $prato["id"]; ?>"
                   onclick="return confirm('Deseja excluir mesmo?')">
                    Excluir
                </a>
            </td>

        </tr>

    <?php } ?>
<?php if ($filtro_usuario && mysqli_num_rows($pratos) == 0) { ?>

    <tr>
        <td colspan="7">
            Este usuário ainda não possui pratos cadastrados.
        </td>
    </tr>

<?php } ?>
</table>
                

        </div>

    </main>

    <footer>

    </footer>

</body>

</html>