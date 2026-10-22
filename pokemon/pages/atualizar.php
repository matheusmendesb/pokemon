<?php
// chama o arquivo conexao
require "../config/conexao.php";

// pega os dados atualizados do formulario
$id = (int) $_POST["id"];
$pokemon = htmlspecialchars(trim($_POST["pokemon"]));
$nota = (float) $_POST["nota"]; 
$comentario = htmlspecialchars(trim($_POST["comentario"]));

// impede notas fora do limite de 0 a 10
if ($nota < 0 || $nota > 10.0) {
    die("Erro: A nota máxima permitida é 10 e não pode ser menor que 0.");
}

// cria o comando sql de update usando o id
$sql = "UPDATE comentarios SET pokemon='$pokemon', nota=$nota, comentario='$comentario' WHERE id=$id";

// executa a atualizacao
if(mysqli_query($conexao, $sql)){
    // retorna o usuario para a home
    header("Location: ../index.html");
} else {
    // exibe o erro se falhar
    echo "Erro: " . mysqli_error($conexao);
}
?>