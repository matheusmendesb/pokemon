<?php
// chama o arquivo conexao
require "../config/conexao.php";

// pega o id vindo da url
$id = (int) $_GET["id"];

// busca os dados apenas do registro dono desse id
$resultado = mysqli_query($conexao, "SELECT * FROM comentarios WHERE id = $id");

// transforma o resultado em uma lista associativa
$dado = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Avaliação</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Pokédex Comentários</h1>
        <nav><a href="../index.html">Voltar para Home</a></nav>
    </header>
    <main>
        <section>
            <h2>Editar Comentário do Pokémon</h2>
            <form action="atualizar.php" method="POST">
                <input type="hidden" name="id" value="<?= $dado['id'] ?>">

                <label>Pokemon</label>
                <input type="text" name="pokemon" value="<?= htmlspecialchars($dado['pokemon']) ?>" required>

                <label>Nota</label>
                <input type="number" name="nota" min="0" max="10" step="0.1" value="<?= $dado['nota'] ?>" required>

                <label>Comentario</label>
                <textarea name="comentario" required><?= htmlspecialchars($dado['comentario']) ?></textarea>

                <button type="submit">Atualizar</button>
            </form>
        </section>
    </main>
</body>
</html>