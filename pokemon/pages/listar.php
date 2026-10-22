<?php
// chama o arquivo conexao
require "../config/conexao.php";

// busca todos os dados da tabela
$resultado = mysqli_query($conexao, "SELECT * FROM comentarios");

// para o codigo se a tabela estiver vazia
if (mysqli_num_rows($resultado) == 0) {
    die("<p style='text-align:center; color:#666;'>Nenhum comentário cadastrado.</p>");
}
?>

<table border="1">
    <tr> <th>ID</th> <th>Pokémon</th> <th>Nota</th> <th>Comentário</th> <th>Ações</th> </tr>

    <?php 
    // faz um loop para listar cada linha do banco
    while ($dados = mysqli_fetch_assoc($resultado)) { 
    ?>
        <tr>
            <td><?= $dados["id"] ?></td>
            <td><?= htmlspecialchars($dados["pokemon"]) ?></td>
            <td><?= $dados["nota"] ?></td>
            <td><?= htmlspecialchars($dados["comentario"]) ?></td>
            <td>
                <a href="pages/editar.php?id=<?= $dados['id'] ?>">Editar</a> | 
                <a href="pages/excluir.php?id=<?= $dados['id'] ?>" onclick="return confirm('Excluir?')">Excluir</a>
            </td>
        </tr>
    <?php 
    }
    ?>
</table>