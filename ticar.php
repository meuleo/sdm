<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['nome']) && !isset($_POST['abrirFolha'])) {
    // Verifica se um botão "Guardar" foi clicado
    $dataTic = '';
    $dataTic = $_POST['dataGlobal'] ?? null;

    $linha = $_POST['linha'] ?? null;
    $marcado = "";
    $desmarcado = "";

    // echo "<br><br> linha ".$linha."<br><br>";
    
    foreach ($_POST as $key => $value) {
        if (strpos($key, '_guardar') !== false) {
            // Extrai o número da linha do nome do botão
            $linha_numero = intval(substr($key, 6));

            // Obtém o estado dos checkboxes da linha atual
            $checkbox_1 = isset($_POST["linha_{$linha_numero}_checkbox_1"]) ? true : false;
            $checkbox_2 = isset($_POST["linha_{$linha_numero}_checkbox_2"]) ? true : false;

            // Faça o que for necessário com os estados dos checkboxes (por exemplo, salvá-los no banco de dados)
            // Neste exemplo, estamos salvando os estados em variáveis separadas para cada linha
            $marcado = $checkbox_1 ? "true" : "false";
            $desmarcado = $checkbox_2 ? "true" : "false";

            // Aqui, estamos apenas imprimindo-os como exemplo
            // echo "Linha {$linha_numero}: Checkbox 1 = {$marcado}, Checkbox 2 = {$desmarcado}";
            break; // Pode remover esta linha se houver mais botões na tabela
        }
    }

    // Guardar Tic
    $jsonFile = file_get_contents('ticar.json');
    // Decodifica o JSON em um array associativo
    $data = json_decode($jsonFile, true);


    // Verifica se o índice 'tics' está definido em cada item do array
    foreach ($data as $key => $item) {    
        // Verifica se o nome existe no subarray
        if ($dataTic == $item['data']) {
            // echo "Existe data: </br>". $item['data'] . " ===  ". $pushData; //Se existe data não cria
            // echo 'gravar';
            foreach($item['tics'] as $tics){
                // echo "<br><br>key ".$tics['linha']."<br><br>";

                $arquivoJSON = 'ticar.json';
                $dados = file_exists($arquivoJSON) ? json_decode(file_get_contents($arquivoJSON), true) : [];
    
                // Obtém os dados do formulário
                // Adiciona os dados ao array
                foreach($dados[$key]['tics'][$linha_numero]['checkbox'] as $check){
                    $dados[$key]['tics'][$linha_numero]['checkbox']['check1'] = $marcado;
                    $dados[$key]['tics'][$linha_numero]['checkbox']['check2'] = $desmarcado;
                }
                
               
        
                // Salva os dados em um arquivo JSON
                salvarDadosEmJSON($dados, $arquivoJSON);    
                
            }            
        }         
    }
}        
?>

<?php
// Função para salvar os dados em um arquivo JSON
$erroAdiocionarNome = "";

function salvarDadosEmJSON($dados, $arquivo)
{
    $jsonData = json_encode($dados, JSON_PRETTY_PRINT);
    file_put_contents($arquivo, $jsonData);
}

$dataGlobal = "";
$dataNome = "";
// $dataTicAux = $dataTic ?? null;
$dataTic = isset($dataTic) ? $dataTic : null;

// Verifica se o formulário foi enviado
if (isset($_POST['abrirFolha']) || $dataTic != '') {
        $erroAdiocionarNome = 1;
        
        // echo "abri Folha </br>";
        // $nome = $_POST['nome'];
        $pushData = $_POST['data'] ?? null;
        // Sua data no formato do PHP
        $dia = $_POST['dia'] ?? null;

        if($dataTic != ''){
            $dia = "1";
            $pushData = $dataTic;
        }

        if($dia != ''){

        // echo "Dia ".$dia; 
        
        $erroAdiocionarNome = 0;
        $dataNome = $data_php = $pushData;

        // Converter a data do PHP para o formato de data do JavaScript
        $data_js = date("Y-m-d", strtotime($data_php));

        // echo "data Global: ".$data_js."</br>";

        $jsonFile = file_get_contents('ticar.json');
        // Decodifica o JSON em um array associativo
        $data = json_decode($jsonFile, true);

        $cont = 0;
        $OpenExiteData = 0;
        // Verifica se o índice 'tics' está definido em cada item do array
        foreach ($data as $item) {    
            // Verifica se o nome existe no subarray
            if ($pushData == $item['data']) {
                // echo "Existe data: </br>". $item['data'] . " ===  ". $pushData; //Se existe data não cria
                $OpenExiteData = 1;
                $cont++;
            }         
        }

        if($cont < 1 ){
            // echo "Criando nova Folha <br>";

            $arquivoJSON = 'ticar.json';
            $dados = file_exists($arquivoJSON) ? json_decode(file_get_contents($arquivoJSON), true) : [];

            // Obtém os dados do formulário
            // Adiciona os dados ao array
            // $dados['tics'][]
            $dados[] = [
                "sabado" => $dia,
                "data" => $pushData,
                "tics" => []
            ];

            // Salva os dados em um arquivo JSON
            salvarDadosEmJSON($dados, $arquivoJSON);

            // Exibe uma mensagem de sucesso
            // echo '<p>Dados salvos com sucesso!'.$pushData.'</p>';
        // }

        }

    }
}
?>




<!-- Add Tics -->
<?php 
        if (isset($_POST['nome'])) {
      
        // echo "<br><br>abri Folha <br>";
        $nome = $_POST['nome'];
        $dataNome = $_POST['dataGlobal'];
        // echo "Data Nome ".  $dataNome ."<br>";

        $pushData = $_POST['dataGlobal'];
        // Sua data no formato do PHP
        $data_php = $pushData;

        // Converter a data do PHP para o formato de data do JavaScript
        $data_js = date("Y-m-d", strtotime($data_php));

        // echo "data Global: ".$data_js."</br>";

        $jsonFile = file_get_contents('ticar.json');
        // Decodifica o JSON em um array associativo
        $data = json_decode($jsonFile, true);
        
        // Verifica se o índice 'tics' está definido em cada item do array
        $cont = 0;
        $key1 = 0;
        $key2 = 0;
        $indexLinhaGuardar = 0;

        foreach ($data as $key => $item) {

             if ($dataNome == $item['data']){
                // echo "Existe to data Nome <br>".$dataNome." igual a ".$item['data']."<br>";
                $key1 = $key;

                // echo "key <br>".$key."<br>";

                    foreach ($item['tics'] as $key2 => $value) {
                        // Verifica se o nome existe no subarray Actualiza
                        // echo "Linha guardar ".$key2;
                        if( $key2 == 0){
                            $indexLinhaGuardar = $key2+1;
                        }
                        else {
                            $indexLinhaGuardar = $key2+1;
                        }

                        if ($value['nome'] == $nome) {
                            // echo "Boas! encontrei... Não vou criar mais <br><br>";
                            // $indexLinhaGuardar = $key2;

                            $cont++;

                            // echo "Ops! não encontrei... Vou criar Agora <br><br>";
                            // echo "Criando novo Nome <br>";
                
                            $arquivoJSON = 'ticar.json';
                            $dados = file_exists($arquivoJSON) ? json_decode(file_get_contents($arquivoJSON), true) : [];
                    
                            // Obtém os dados do formulário
                            // Adiciona os dados ao array
                            // $dados['tics'][]
                            // $dados[1]['tics'][] = [
                            //     "nome" => $nome,
                            //     "linha" => 0,
                            //     "checkbox" => ["1", "0"]
                            // ];

                            foreach($value['checkbox'] as $checks){
                                // echo "check: ".$checks;
                            }
                    
                            // Salva os dados em um arquivo JSON
                            salvarDadosEmJSON($dados, $arquivoJSON);
                    
                            // Exibe uma mensagem de sucesso
                            // echo '<p>Dados salvos com sucesso!'.$pushData.'</p>';
                        }
                    }   
                
             }
        }

        if($cont < 1){
            // echo "Boas! encontrei... Não vou criar mais <br><br>";
            $cont++;

            // echo "Ops! não encontrei... Vou criar Agora <br><br>";
            // echo "Criando novo Nome <br>";

            $arquivoJSON = 'ticar.json';
            $dados = file_exists($arquivoJSON) ? json_decode(file_get_contents($arquivoJSON), true) : [];
    
            // Obtém os dados do formulário
            // Adiciona os dados ao array
            // $dados['tics'][]
            
            $dados[$key1]['tics'][] = [
                "nome" => $nome,
                "linha" => $indexLinhaGuardar,
                "checkbox" => [
                    "check1" => "0",
                    "check2" => "0"
                    ]
            ];
    
            // Salva os dados em um arquivo JSON
            salvarDadosEmJSON($dados, $arquivoJSON);
    
            // Exibe uma mensagem de sucesso
            // echo '<p>Dados salvos com sucesso!'.$pushData.'</p>';
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <style>
        a {
          text-decoration: none;
          color: #fff;
        }

        .linha {
            display: flex;
            flex-wrap: wrap;
        }

        #nomes-lista button {
            background: #8d8d8d;
            margin: 3px;
            cursor: pointer;
            padding: 5px;
        }

        #filtro:focus {
            outline: none;
        }

        .filtrar {
            border: 1px solid rgba(0,0,0,0.3);
            border-radius: 2em;
            overflow: hidden;
        }

        .filtrar span {
            opacity: 0.5;
        }
        .menu p {
            margin: 0.5em;
            border-radius: 8px;
            background: #272727;
            padding: 0.3em;
            padding-left: 1em;
        }
        .devlink {
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
        }
        .box2 {
            border-bottom: 1px solid rgba(0,0,0,0.5);
        }
    </style>
</head>
<body>
    <div class="linha">
    <div class="col-12">
        <div class="fixed-top">
            <div class="row bg-dark px-2">
                <div class="col-8">
            <!-- Nova navbar -->
            <div class="" style="color: #fff;">
            <div class="py-3 ">
                <button class="btn btn-sm btn-dark" style="background-color: #707070;" onclick="goBack()">
                    〈 voltar
                </button>
                <a href="nomes.php">
                    <button class="btn btn-sm btn-dark" style="background-color: #707070;">
                        Nomes
                    </button>
                </a>
                <a href="ticar.php"><button class="btn btn-sm btn-dark" style="background-color: rgb(194, 77, 77);">
                    Ticar
                </button></a>
                <a href="index.php"><button class="btn btn-sm btn-dark" style="background-color: #707070;">
                    Folha Completa
                </button></a>
                <button class="btn btn-sm btn-dark" style="background-color: #707070;" onclick="showImportar()">
                    Importar
                </button>
                <button class="btn btn-sm btn-dark" style="background-color: #707070;" onclick="showExportar()">
                    Exportar
                </button>
            </div>
            <h5>Folha de controle de Fidelidade</h5>
            <div class="">
            <!-- Lista Feita -->
            <div class="col-6"><h5 class="py-3">Ticar Folha</h5></div>
            </div>
        </div>
        <!-- Fim Nova navbar -->
            </div>
            <div class="col-4">
                <div class="text-center pt-3">
                    <img src="assets/logo2.jpg" alt="" width="80">
                    <p class="pt-2" style="font-size: 0.8em; font-style: italic; color: #fff;">
                        <b> IGREJA ADVENTISTA DO SÉTIMO DIA <br>
                        MISSÃO SUL </b>
                    </p>
                </div>
            </div>
        </div>
        </div>

        <div class="invisible">
            
        </div class="">
        <!-- Fim Nova navbar -->
            <br><br><br>
            <br><br><br><br>
        </div>

        </div>

        <div class="px-5 pt-3">
            <div class="invisible">
                <h5>Ticar</h5>
            </div>
            <div  class="linha">
                <div class="col-8">
                    <form method="post" id='meuForm'>
                        <div class="linha">

                            <div class="col-2">
                            <div class="col-12 px-2">
                                <select class="form-select" name="dia" id="">
                                    <option value="" selected disabled>Sábado</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="2">3</option>
                                    <option value="2">4</option>
                                    <option value="2">5</option>
                                </select>
                            </div>
                            </div>

                            <div class="col-4">
                                <div class="col-12 px-2">
                                    <input type="date" name="data" class="form-control" required>
                                </div>
                            </div>

                            <div>
                                <button class="btn btn-success" type="submit" name="abrirFolha">Abrir Folha</button>
                            </div>
                            
                        </div>
                    </form>
                </div>
                <div>
                    <div class="col-8" style="position: relative;">
                        <div class="filtrar">
                            <input class="col-8 p-1 ps-3" type="text" id="filtro" placeholder="procurar" style="padding: 0.28em; border: none;">
                            <span><img src="assets/procurar.png" alt="" style="width: 35px;"></span>
                        </div>
                        <div class="col-12 py-1" id="nomes-lista" style="display: none; position: absolute; background: #a7a7a7;"></div>
                    </div>
                </div>
            </div>

            <p style='color: red; margin: 0; padding-top: 15px; visibility: hidden;' id="erro">Você não selecionou o Sábado!</p>

            <?php 
                if($erroAdiocionarNome == 1){
                    echo "<script>
                            document.getElementById('erro').style.visibility = 'visible' 
                          </script>
                    ";
                }
            ?>

            <?php
                // // Insere nome a ser ticado
                // // Deve verificar se existe folha, pode ser so o estado de uma variavel

                // $jsonFile = file_get_contents('nomes.json');
                // // Decodifica o JSON em um array associativo
                // $data = json_decode($jsonFile, true);
        
                // if ($data !== null) {
                //     foreach ($data as $item) {
                        
                //     }
                // }
                 
            ?>
            <br>
            <div class="col-3 pt-2 pb-3 d-none">
                <select name="letraNome" id="">
                    <option value="A">A</option>
                    <option value="B">B</option>
                </select>
            </div>

            <div>
                <div>
                <form method="post" action="">
                    <table class="table col-12">
                        <tr class="bg-dark" style="color: #fff;">
                            <td>#</td>
                            <td>Nome</td>
                            <td class='text-center'>Marcar</td>
                            <td class='text-center'>Ticar</td>
                            <td class='text-center'>Apagar</td>
                        </tr>
                        <?php
                            $jsonFile = file_get_contents('ticar.json');
                            // Decodifica o JSON em um array associativo
                            $data = json_decode($jsonFile, true);
                           
                            // $dataNome = $_POST['dataGlobal'];
                            
                            if ($data !== null) {
                                foreach ($data as $item) {
                                    if($item['data'] == $dataNome){
                                    echo "Aberta Folha de : <b>".$item['data']."</b> | Lembre-se sempre de Ticar";

                                    //Invertendo o Array junto com o Key
                                    $dataReverse = array_reverse($item['tics']);
                                    $keys = array_keys($item['tics']);
                                    $reversedKeys = array_reverse($keys);
                                    
                                    $invertedArray = array_combine($reversedKeys, $dataReverse);
                                    
                                    foreach ($invertedArray as $key => $tics) {
                                        // Imprime os dados em cada linha da tabela
                                        echo "<tr>";
                                        echo "<td class='box2 pt-3'>" . "#" . "</td>";
                                        echo "<td class='box2 pt-3'>" . $tics['nome'] . "</td>";

                                        echo "<td class='text-center box2'>" .
                                            "D <input type='checkbox' class='linha-{$key}' name='linha_{$key}_checkbox_1' " . ($tics['checkbox']['check1'] === 'true' ? 'checked' : '') . "><br>" .
                                            "O <input type='checkbox' class='linha-{$key}' name='linha_{$key}_checkbox_2' " . ($tics['checkbox']['check2'] === 'true' ? 'checked' : '') . ">" .
                                            "</td>";
                            
                                        echo "<td class='box2 text-center pt-3'><button class='btn btn-success' type='submit' name='linha_{$key}_guardar'>Ticar </button></td>";
                                        echo "<td class='box2 text-center pt-3'>" . "<div class='bg-danger col-2 rounded-2 text-center py-2 mx-auto'><img src='assets/apagar.png'  alt='' style='width: 23px;'></div>" . "</td>";
                            
                                        echo "<td class='box2 text-center pt-3 d-none'>" . "<input type='text' name='dataGlobal' value='" . $dataNome . "'>" . "</td>";
                                        echo "<td class='box2 text-center pt-3 d-none'>" . "<input type='text' name='linha' value='" . $tics['linha'] . "'>" . "</td>";
                                        echo "</tr>";
                                    }
                                  }
                                }
                            } else {
                                echo "<tr><td colspan='3'>Não foi possível ler o arquivo JSON ou o JSON é inválido.</td></tr>";
                            }

                        ?>
                        </table>
                    
                    </form>
                    </div>

            </div>
        </div>

    </div>
</div>

<div id="Exportar" class="fixed-top d-flex d-none" style="justify-content: center; align-items: center; height: 100vh;">
        <div class="modal-exportar bg-success col-3 rounded-2 border border-dark border-1" style="height: 70%; box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.7);">
            <div>
                <div class="row px-2">
                    <div class="col-6">
                        <h5 class="invisible">Exportar</h5>
                    </div>
                    <div class="col-6 text-end pt-2">
                        <h5><button class="btn" onclick="hideExportar()"><b>X</b></button></h5>
                    </div>
                </div>
                <div class="px-4" >
                    <h5 class="invisible">Exportar</h5>
                    <!-- <a href=""><p class="mb-1" style="color: #000;" hidden>» Exportar nomes</p></a> -->
                    <a href="exportar_tics.php"><h5 class="btn btn-info col-12" style="background-color: rgb(100, 190, 120);">Exportar tics</h5></a>
                </div>
                <div style="padding-top: 16em; opacity: 0.6;">
                    <p class="text-center">
                        by: <a href="http://devaholic.ao" style="color: blue; text-decoration: underline;">DevAholic</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Importar -->
    <div id="Importar" class="fixed-top d-flex d-none" style="justify-content: center; align-items: center; height: 100vh;">
        <div class="modal-exportar bg-success col-3 rounded-2 border border-dark border-1" style="height: 70%; box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.7);">
            <div>
                <div class="row px-2">
                    <div class="col-6">
                        <h5 class="invisible">Exportar</h5>
                    </div>
                    <div class="col-6 text-end pt-2">
                        <h5><button class="btn" onclick="hideImportar()"><b>X</b></button></h5>
                    </div>
                </div>
                <div class="px-4" >
                <div>
                    <h5 class="invisible">Exportar</h5>
                    <!-- <a href=""><p class="mb-1" style="color: #000;" hidden>» Exportar nomes</p></a> -->
                    <h5 class="pb-2 text-center">Importar tics</h5>
                </div>
                    <div>
                        <form action="importar_tics.php" method="post" enctype="multipart/form-data">
                            <p class="mb-1" hidden>Importar tics</p>
                            <input class="form-control" type="file" name="jsonFile" accept=".json">
                            <input type="submit" value="Importar" class="btn btn-info col-12 mt-3" style="background-color: rgb(100, 190, 120);">
                        </form>
                    </div>
                    </div>
                </div>
                <div style="padding-top: 16em; opacity: 0.6;">
                    <p class="text-center">
                        by: <a href="http://devaholic.ao" style="color: blue; text-decoration: underline;">DevAholic</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="bootstrap/bootstrap.min.js"></script>
    <script src="jquery/jquery-3.7.0.min.js"></script>
    
    <?php
        // Verifica se o arquivo existe
        $nomeArquivo = 'nomes.json';
        if (!file_exists($nomeArquivo)) {
            die("O arquivo $nomeArquivo não existe.");
        }

        // Lê o conteúdo do arquivo
        $jsonString = file_get_contents($nomeArquivo);

        // Decodifica o JSON para uma variável PHP
        $nomesArray = json_decode($jsonString, true);

        $nomesJson = json_encode($nomesArray);

        // Verifica se houve algum erro na decodificação
        if ($nomesArray === null && json_last_error() !== JSON_ERROR_NONE) {
            die("Erro ao decodificar o JSON: " . json_last_error_msg());
        }

        // Agora, $nomesArray contém o conteúdo do arquivo JSON
        // print_r($nomesArray);
    ?>

<!-- Script JavaScript -->
<script>
    var nomes1 = [];

    // Supondo que você tenha um array chamado "dados" com os nomes em formato JSON (como mostrado no código original)
    var dados = <?php echo $nomesJson; ?>;
    console.log(dados);

    dados.forEach(el => {
        nomes1.push(el.nome);
        console.log("nome: " + nomes1);
    });

    // Array de nomes (pode ser qualquer array que desejar)
    const nomes = nomes1;

    var dataJavaScript = "<?php echo $data_js; ?>"
    console.log(dataJavaScript)



    // Função para atualizar a lista de nomes filtrados
    function atualizarListaFiltrada(filtro) {
        const lista = document.getElementById("nomes-lista");
        lista.innerHTML = "";

        if (filtro.trim() === "") {
            lista.style.display = "none"; // Oculta a lista se o filtro estiver vazio
        } else {
            const nomesFiltrados = nomes.filter((nome) =>
                nome.toLowerCase().includes(filtro.toLowerCase())
            );

            nomesFiltrados.forEach((nome) => {
                const form = document.createElement("form");
                form.method = "post";
                form.action = "<?php echo $_SERVER['PHP_SELF'];?>";

                const input = document.createElement("input");
                input.classList.add('d-none')
                input.type = "text";
                input.name = "nome";
                input.value = nome; // Preenche o input com o nome filtrado

                const inputData = document.createElement('input')
                inputData.type = 'text'
                inputData.name = 'dataGlobal'
                inputData.value = ''+ dataJavaScript +''
                inputData.classList.add('d-none')

                const button = document.createElement("button");
                button.type = "submit";
                button.textContent = nome; // Define o conteúdo do botão (pode ser dinâmico também)
                button.classList.add('btn','btn-sm', 'col-11','px-2', 'd-block','mx-auto')

                form.appendChild(input);
                form.appendChild(button);
                form.appendChild(inputData);

                console.log(inputData)

                lista.appendChild(form);
            });

            lista.style.display = "block"; // Mostra a lista se houver nomes filtrados
        }
    }

    // Função para lidar com o evento de input no campo de filtro
    function handleFiltroChange() {
        const filtro = document.getElementById("filtro").value;
        atualizarListaFiltrada(filtro);
    }

    // Adicionar um event listener para o campo de filtro
    document.getElementById("filtro").addEventListener("input", handleFiltroChange);
</script>


<!-- ================= Actualizar Checkbox ============= -->
<!-- <script>
    const estado = [];

    function atualizarEstado(linha, checkboxIndex, valor) {
      const linhaExistente = estado.find(item => item.linha === linha);

      if (linhaExistente) {
        linhaExistente.checkbox[checkboxIndex] = valor;
      } else {
        // estado.push({ linha, checkbox: [false, false] });
        estado.push({ linha, checkbox: [false, false] });
        estado[estado.length - 1].checkbox[checkboxIndex] = valor;
      }

      console.log(estado);
    }

    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        const linha = parseInt(this.className.replace('linha-', ''));
        const checkboxIndex = Array.from(this.parentNode.parentNode.children).indexOf(this.parentNode);

        atualizarEstado(linha, checkboxIndex, this.checked);
      });
    });
  </script> -->

  <!-- Não processar pagina ao enviar -->
  <script>
      function goBack() {
          window.history.back();
      }
  </script>
  
  <script>
    function showExportar() {
        document.getElementById('Exportar').classList.remove('d-none');
    }
        
    function hideExportar() {
        document.getElementById('Exportar').classList.add('d-none');
    }
  </script>

  <script>
    function showImportar() {
        document.getElementById('Importar').classList.remove('d-none');
    }
    
    function hideImportar() {
        document.getElementById('Importar').classList.add('d-none');
    }
  </script>

</body>
</html>