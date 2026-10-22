<?php
// chama o arquivo conexao
require "../config/conexao.php";

// pega o id da url por seguranca
$id = (int) $_GET["id"];

// deleta a linha do banco usando o id correspondente
$sql = "DELETE FROM comentarios WHERE id = $id";

// executa a exclusao
if(mysqli_query($conexao, $sql)){
    // se der certo volta para a pagina inicial
    header("Location: ../index.html");
} else {
    // se der erro mostra o motivo na tela
    echo "Erro: " . mysqli_error($conexao);
}
?>