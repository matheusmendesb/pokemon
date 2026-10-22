<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "pokemon_bd";

// realiza a conexao com o banco de dados
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

// verifica se a conexao falhou
if (!$conexao) {
    // para o codigo e exibe o erro
    die("Erro Na Conexao: " . mysqli_connect_error());
}

// define o charset utf8 para nao quebrar os acentos
mysqli_set_charset($conexao, "utf8");
?>