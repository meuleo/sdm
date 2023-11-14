<?php
// Nome do arquivo JSON
$nomeArquivo = 'ticar.json';

// Define o nome do arquivo para download
$nomeArquivoDownload = basename($nomeArquivo);

// Define o cabeçalho para download
header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="' . $nomeArquivoDownload . '"');

// Envia o conteúdo do JSON para o navegador
echo file_get_contents($nomeArquivo);
?>