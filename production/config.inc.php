<?php

echo "OK";

function baixarPDF($caminho, $nome){

    //Variáveis
    $bool = false;
    $arquivo_nome = "{$nome}";
    $arquivo = "{$caminho}/{$nome}";

    //Verifica se o arquivo existe
    if(!empty($arquivo_nome) && file_exists($arquivo)){
        header('Content-type: application/pdf');
        header("Content-disposition: attachment; filename={$arquivo_nome}");
        $bool = readfile($arquivo);
    }

    //Retorna o erro
    return $bool;
}