<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['jsonFile']) && $_FILES['jsonFile']['error'] === UPLOAD_ERR_OK) {
        $nomeArquivo = 'nomes.json';
        
        // Move o arquivo para o destino desejado
        move_uploaded_file($_FILES['jsonFile']['tmp_name'], $nomeArquivo);
        
        echo "<a href='index.php'>voltar</a><br><br>";
        echo "Nomes Actualizados com sucesso!";
    } else {
        echo "Erro ao importar o arquivo JSON.";
    }
}
?>