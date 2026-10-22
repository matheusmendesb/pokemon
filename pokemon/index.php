<?php
require "config/conexao.php";

if ($conexao) {
    //ele puxa e exibe o corpo do site
    include "index.html";
} else {
    // mostra o erro se falhar
    echo "Erro: Não foi possível conectar ao banco de dados.";
}
?>