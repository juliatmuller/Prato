<?php

include "infra/conexao.php";
$livros = mysqli_query($conexao, "SELECT * FROM prato");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Prato</title>
    <link rel="stylesheet" href="style/styles.css">
</head>

<body>
    <header>
        <h1>CRUD - Prato</h1>
    </header>
    <main>
        <h2>Adicione um novo Prato!</h2>
        <form action="public/cadastrar.php" method="POST">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo">
            <br>
            <label for="autor">Autor:</label>
            <input type="text" name="autor">
            <br>
            <label for="ano">Ano de Publicação:</label>
            <input type="number" name="ano">
            <br>
            <button type="submit">Cadastrar</button>
        </form>
        <div>
            <h2>Prato Cadastrados</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Ano</th>
                    <th>Ações</th>
                </tr>
                <?php while ($prato = mysqli_fetch_assoc($prato)) { ?>
                    <tr>
                        <td><?php echo $prato["nome"] ?></td>
                        <td><?php echo $prato["descricao"] ?></td>
                        <td><?php echo $prato["preco"] ?></td>
                        <td><?php echo $prato["categoria"] ?></td>
                        <td>
                            <a href="public/editar.php?id=<?php echo $prato["id"] ?>">Editar</a>
                            <a href="public/excluir.php?id=<?php echo $prato["id"] ?>">Excluir</a>
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