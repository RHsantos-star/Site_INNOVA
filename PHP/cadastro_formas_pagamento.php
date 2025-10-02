<?php

// Conectando este arquivo ao banco de dados
require_once __DIR__ ."/conexao.php";

// função para capturar os dados passados de uma página a outra
function redirecWith($url,$params=[]){
// verifica se os os paramentros não vieram vazios
 if(!empty($params)){
// separar os parametros em espaços diferentes
$qs= http_build_query($params);
$sep = (strpos($url,'?') === false) ? '?': '&';
$url .= $sep . $qs;
}
// joga a url para o cabeçalho no navegador
header("Location:  $url");
// fecha o script
exit;
}

try{
     if($_SERVER["REQUEST_METHOD"] !== "POST"){
        //VOLTAR À TELA DE CADASTRO E EXIBIR ERRO
        redirecWith("../paginas/frete_pagamento.html",
           ["erro"=> "Metodo inválido"]);
    }

    $nomepagamento = $_POST["nomepagamento"];

    // validação 

     //se qualquer campo for vazio
    if($bairro === "" || $valor ==="" ){
        $erros_validacao[]="Preencha todos os campos";
    }

     Inserir o frete no banco de dados */
    $sql ="INSERT INTO 
    Forma_pagamento (nome)
     Values (:nomepagamento)";
     // executando o comando no banco de dados
     $inserir = $pdo->prepare($sql)->execute([
        ":nomepagamento" => $nomepagamento     
     ]);

      /* Verificando se foi cadastrado no banco de dados */
     if($inserir){
        redirecWith("../paginas/forma_pagamento.html",
        ["cadastro" => "ok"]) ;
     }else{
        redirecWith("../paginas/forma_pagamento.html"
        ,["erro" =>"Erro ao cadastrar no banco
         de dados"]);
     }



}catch(Exception $e){
    redirecWith("../paginas/frete_pagamento.html",
      ["erro" => "Erro no banco de dados: "
      .$e->getMessage()]);
}





?>