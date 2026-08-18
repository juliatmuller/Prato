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

$usuarios = mysqli_query($conexao, "SELECT * FROM usuario");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Restaurante</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>

    <header>
        <h1>CRUD - Restaurante</h1>
        <nav>
            <a href="public/usuarios.php">Gerenciar Usuários</a> | 
            <a href="public/pratos.php">Ver Todos os Pratos</a>
        </nav>
    </header>

    <main>

        <h2>Cadastrar Usuário</h2>

        <form action="public/usuario_cadastrar.php" method="POST">

            <label for="nome_usuario">Nome:</label>
            <input type="text" id="nome_usuario" name="nome" required>

            <br>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <br>

            <button type="submit">Cadastrar Usuário</button>

        </form>

        <h2>Adicionar um novo prato!</h2>

        <form action="public/prato_cadastrar.php" method="POST">

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
            <input type="text" id="categoria" name="categoria" required>

            <br>

            <label for="id_usuario">Usuário responsável:</label>

            <select id="id_usuario" name="id_usuario" required>

                <option value="">Selecione um usuário</option>

                <?php 
                mysqli_data_seek($usuarios, 0);
                while ($usuario = mysqli_fetch_assoc($usuarios)) { 
                ?>
                    <option value="<?php echo $usuario["id"]; ?>">
                        <?php echo $usuario["nome"]; ?>
                    </option>
                <?php } ?>

            </select>

            <br>

            <button type="submit">Cadastrar Prato</button>

        </form>

        <div>

            <h2>
                Pratos Cadastrados
                <?php if ($filtro_usuario): ?>
                    (Filtrado por usuário) - <a href="index.php">Limpar filtro</a>
                <?php endif; ?>
            </h2>

            <!-- Filtro por Usuário (RF6) -->
            <form action="index.php" method="GET">
                <label for="usuario_id">Filtrar por Usuário:</label>
                <select name="usuario_id" id="usuario_id" onchange="this.form.submit()">
                    <option value="">Todos os usuários</option>
                    <?php 
                    mysqli_data_seek($usuarios, 0);
                    while ($u = mysqli_fetch_assoc($usuarios)) { 
                    ?>
                        <option value="<?php echo $u['id']; ?>" <?php echo ($filtro_usuario == $u['id']) ? 'selected' : ''; ?>>
                            <?php echo $u['nome']; ?>
                        </option>
                    <?php } ?>
                </select>
            </form>

            <br>

            <table>

                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Categoria</th>
                    <th>Cadastrado por</th>
                    <th>Ações</th>
                </tr>

                <?php while ($prato = mysqli_fetch_assoc($pratos)) { ?>

                    <tr>

                        <td><?php echo $prato["id"]; ?></td>
                        <td><?php echo $prato["nome"]; ?></td>
                        <td><?php echo $prato["descricao"]; ?></td>
                        <td>R$ <?php echo number_format($prato["preco"], 2, ',', '.'); ?></td>
                        <td><?php echo $prato["categoria"]; ?></td>
                        <td><?php echo $prato["usuario_nome"]; ?></td>

                        <td>
                            <a href="public/prato_editar.php?id=<?php echo $prato["id"]; ?>">Editar</a>
                            <a href="public/prato_excluir.php?id=<?php echo $prato["id"]; ?>" onclick="return confirm('Deseja excluir mesmo?')">Excluir</a>
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