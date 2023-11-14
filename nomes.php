<?php
// Verifica se há uma solicitação de exclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $indexToDelete = $_POST['index'];

    // Carrega o arquivo JSON
    $jsonFile = 'nomes.json';
    $jsonContent = file_get_contents($jsonFile);
    $data = json_decode($jsonContent, true);

    // Remove o registro correspondente ao índice
    if (isset($data[$indexToDelete])) {


        unset($data[$indexToDelete]);

        // Reindexa o array
        $data = array_values($data);

        // Codifica o array em JSON novamente
        $jsonContent = json_encode($data, JSON_PRETTY_PRINT);

        // Escreve o JSON de volta no arquivo
        file_put_contents($jsonFile, $jsonContent);
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

// Função de comparação personalizada para ordenar por nome
function compararPorNome($a, $b) {
    return strcmp($a['nome'], $b['nome']);
}

// Verifica se o formulário foi enviado
if (isset($_POST['enviar'])) {
    $erroAdiocionarNome = 0 ?? null;
    // Verifica se os campos estão preenchidos
    if ($_POST['nome'] != '' && isset($_POST['batizado'])) {
        // Lê o conteúdo atual do arquivo JSON
        $arquivoJSON = 'nomes.json';
        $dados = file_exists($arquivoJSON) ? json_decode(file_get_contents($arquivoJSON), true) : [];

        // Obtém os dados do formulário
        $nome = $_POST['nome'];
        $batizado = $_POST['batizado'];
        // $email = $_POST['email'];
        // $mensagem = $_POST['mensagem'];

        // Adiciona os dados ao array
        $dados[] = [
            'nome' => $nome,
            'batizado' => $batizado
        ];

        // Salva os dados em um arquivo JSON
        salvarDadosEmJSON($dados, $arquivoJSON);

        // Exibe uma mensagem de sucesso
        // echo '<p>Dados salvos com sucesso!'.$nome.'</p>';
    }
    else {
        $erroAdiocionarNome = 1;
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
        .linha {
            display: flex;
            flex-wrap: wrap;
        }

        #nomes-lista p {
            background: #8d8d8d;
            margin: 3px;
            cursor: pointer;
            padding: 5px;
        }

        /* #filtro:focus {
            outline: none;
        }

        .filtrar {
            border: 1px solid rgba(0,0,0,0.3);
            border-radius: 2em;
            overflow: hidden;
        }

        .filtrar span {
            opacity: 0.5;
        } */
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

        a {
          text-decoration: none;
          color: #fff;
        }

        /* Estilo para esconder a mensagem original */
        input[type="file"] {
            /* color: transparent; */
        }

        /* Estilo para exibir a mensagem personalizada */
        /* .custom-input::before {
            content: "Selecione um arquivo JSON";
            color: #333;
        } */
    </style>
</head>
<body>
    <div class="linha">
        <div class="col-2 pt-3 px-1 position-fixed" style="background: #3b3b3b; height: 100vh; color: #fff;" hidden>
            <div style="position: relative; height: 94vh;">
                <div class="text-center">
                    <h5>Secretaria da Mordomia</h5>
                    <p>IGREJA NAZARE</p>
                </div>
                <div class="menu">
                    <a href="lista-completa.php"><p>Lista Feita</p></a>
                    <p>Nomes</p>
                    <a href="ticar.php"><p>Ticar</p></a>
                    <p>Importar</p>
                    <p>Exportar</p>
                </div>
                <div class="text-center p-2">
                    <p style="font-style: italic; font-size: 0.9em;">
                    Nenhum dos ídolos das nações pode fazer chover, 
                    nem o céu pode fazer cair chuva. Pusemos a nossa esperança em ti, 
                    ó SENHOR, nosso Deus, pois tu és aquele que faz todas estas coisas. <br>
                    - Jeremias 14:22 -
                    </p>
                </div>

                <div class="text-center devlink" style="position: absolute; bottom: 0;">
                    by: <a href="http://devaholic.ao">devaholic.ao</a>
                </div>
            </div>
        </div>
        
        <!-- <div class="col-2 pt-3 px-1" style="background: #3b3b3b; height: 100vh; color: #fff;">
           Fixed invisible
        </div> -->

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
                    <button class="btn btn-sm btn-dark" style="background-color: rgb(194, 77, 77);">
                        Nomes
                    </button>
                </a>
                <a href="ticar.php"><button class="btn btn-sm btn-dark" style="background-color: #707070;">
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
            <div class="col-6"><h5 class="py-3">Nomes</h5></div>
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

        <div class="px-5 pt-1">
            <div>
                <p class="invisible">Inserir nome</p>
            </div>
            <div  class="linha">
                <div class="col-8">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                        <div class="linha">
                            <div class="col-4">
                                <div style="position: relative;">
                                    <div class="filtrar">
                                        <input class="form-control" type="text" id="filtro" placeholder="Novo nome" name="nome">
                                    </div>
                                    <div class="col-12 py-1" id="nomes-lista" style="display: none; position: absolute; background: #a7a7a7;"></div>
                                </div>
                            </div>
                            <div class="col-3 px-2">
                                <select class="form-select" name="batizado" id="">
                                    <option value="" selected disabled>Batizado</option>
                                    <option value="Sim">Sim</option>
                                    <option value="Não">Não</option>
                                </select>
                            </div>
                            <div>
                                <button class="btn btn-success" type="submit" name="enviar">adicionar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div>
                    <!-- <div class="col-8" style="position: relative;">
                        <div class="filtrar">
                            <input class="col-8 p-1 ps-3" type="text" id="filtro" placeholder="procurar" style="padding: 0.28em; border: none;">
                            <span><img src="assets/procurar.png" alt="" style="width: 35px;"></span>
                        </div>
                        <div class="col-12 py-1" id="nomes-lista" style="display: none; position: absolute; background: #a7a7a7;"></div>
                    </div> -->
                </div>
            </div>
            
            <!-- Abrir json -->
            <?php 
                 $jsonFile = file_get_contents('nomes.json');
                 // Decodifica o JSON em um array associativo
                 $data = json_decode($jsonFile, true);

                 $total = 0;

                 foreach ($data as $item) {
                    $total++;
                 }
            ?>

            <p style='color: red; margin: 0; padding-top: 15px; visibility: hidden;' id="erro">Precenha todos os campos</p>

            <?php 
                if($erroAdiocionarNome == 1){
                    echo "<script>
                            document.getElementById('erro').style.visibility = 'visible' 
                          </script>
                    ";
                }
            ?>

                <div>
                    <p><?php echo "&nbsp;".$total." Nomes Inseridos"; ?></p>
                </div>
            <div class="col-3 pt-2 pb-3" hidden>
                <button class="btn btn-sm btn-dark px-3">〈</button> 1-10 
                <button class="btn btn-sm btn-dark px-3">〉</button> de <?php echo $total; ?>
            </div>
            <div>
                <div>
                    <table class="table col-12">
                        <tr class="bg-dark" style="color: #fff;">
                            <td>Nº</td>
                            <td>Nome</td>
                            <td class='text-center'>Batizado</td>
                            <td class='text-center'>Editar</td>
                            <td class='text-center'>Apagar</td>
                        </tr>
                        <?php
                            //  $dataReverse = array_reverse($data);

                             // Usando a função usort() para ordenar o array
                            // usort($dataReverse, 'compararPorNome');
                            $dataReverse = array_reverse($data);
                            $keys = array_keys($data);
                            $reversedKeys = array_reverse($keys); 
                            $invertedArray = array_combine($reversedKeys, $dataReverse);

                            if ($invertedArray !== null) {
                                foreach ($invertedArray as $key3 =>  $item) {
                                    // Imprime os dados em cada linha da tabela
                                    echo "<tr>";
                                    echo "<td>"."•"."</td>";
                                    echo "<td>" . $item['nome'] . "</td>";
                                    echo "<td class='text-center'>" . $item['batizado'] . "</td>";
                                    echo "<td class='text-center'>" . "<button type='submit' class='bg-success col-3 rounded-2 text-center p-1 mx-auto' style='border: none; background: none; width: 35px;'>
                                    <img src='assets/editar.png' alt='' style='width: 23px;'>
                                    </button>" . "</td>";
                                    echo "
                                    
                                    <td class='text-center'>
                                        <form method='post'>
                                            <input type='hidden' name='action' value='delete'>
                                            <input type='hidden' name='index' value='$key3'>
                                            <button type='submit' class='bg-danger col-3 rounded-2 text-center p-1 mx-auto' style='border: none; background: none; width: 35px;'>
                                            <img src='assets/apagar.png' alt='' style='width: 23px;'>
                                            </button>
                                        </form>
                                    </td>
                                    
                                    ";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>Não foi possível ler o arquivo JSON ou o JSON é inválido.</td></tr>";
                            }
                        ?>
                        </table>
                    </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Exportar -->
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
                    <a href="exportar_nomes.php"><h5 class="btn btn-info col-12" style="background-color: rgb(100, 190, 120);">Exportar nomes</h5></a>
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
                    <h5 class="pb-2 text-center">Importar nomes</h5>
                </div>
                    <div>
                        <form action="importar_nomes.php" method="post" enctype="multipart/form-data">
                            <p class="mb-1" hidden>Importar nomes</p>
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

<script>
    var nomes1 = []

    var dados = <?php echo $nomesJson; ?>;
    console.log(dados);

    dados.forEach(el => {
        nomes1.push(el.nome)
        console.log("nome: " + nomes1)
    })

    // Array de nomes (pode ser qualquer array que desejar)
    const nomes = nomes1

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
          const li = document.createElement("p");
          li.textContent = nome

          const inserido = document.createElement("span");
          const inserido_b = document.createElement("img");
          inserido_b.src = "assets/proximo.png"
          inserido_b.style.width = "22px";
          inserido_b.style.marginLeft = "0.3em";

          li.appendChild(inserido_b);
          li.appendChild(inserido);
          lista.appendChild(li);
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