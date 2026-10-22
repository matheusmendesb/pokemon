<?php
// chama o arquivo conexao
require "../config/conexao.php";

// pega os dados do formulario e protege as variaveis
$pokemon = htmlspecialchars(trim($_POST["pokemon"]));
$nota = (float) $_POST["nota"]; 
$comentario = htmlspecialchars(trim($_POST["comentario"]));

// impede notas menores que 0 ou maiores que 10
if ($nota < 0 || $nota > 10.0) {
    die("Erro: A nota deve ser entre 0 e 10.");
}

// cria o comando sql para salvar no banco
$sql = "INSERT INTO comentarios (pokemon, nota, comentario) VALUES ('$pokemon', $nota, '$comentario')";

// executa o comando e verifica se deu certo
if (mysqli_query($conexao, $sql)) {
    // mostra mensagem de sucesso e volta para a pagina inicial
    echo "<script>alert('Salvo com sucesso!'); window.location.href='../index.html';</script>";
} else {
    // mostra o erro se falhar
    echo "Erro ao salvar: " . mysqli_error($conexao);
}
?>