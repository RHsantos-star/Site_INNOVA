<?php
require_once __DIR__ . "/conexao.php";

// Função para redirecionar com parâmetros
function redirecWith($url, $params = []) {
    if (!empty($params)) {
        $qs = http_build_query($params);
        $sep = (strpos($url, '?') === false) ? '?' : '&';
        $url .= $sep . $qs;
    }
    header("Location: $url");
    exit;
}

// Função para converter imagem em blob
function readImageToBlob(?array $file): ?string {
    if (!$file || !isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) return null;
    $content = file_get_contents($file['tmp_name']);
    return $content === false ? null : $content;
}

try {

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        redirecWith("../paginas_logista/cadastro_produtos_logista.html", ["erro" => "Método inválido"]);
    }

    // Captura os campos do formulário
    $nome = trim($_POST["nomePro"] ?? "");
    $preco = (float)($_POST["precoPro"] ?? 0);
    $tamanho = trim($_POST["tamanho"] ?? "");
    $descricao = trim($_POST["descricao"] ?? "");
    $statusproduto = isset($_POST["statusproduto"]) && $_POST["statusproduto"] == "1" ? 1 : 0;
    $categoria = $_POST["categoria"] ?? null;

    // Validar campos obrigatórios
    $erros_validacao = [];
    if ($nome === "" || $preco <= 0 || $categoria === null) {
        $erros_validacao[] = "Preencha todos os campos obrigatórios!";
    }

    if (!empty($erros_validacao)) {
        redirecWith("../paginas_logista/cadastro_produtos_logista.html", ["erro" => implode(" ", $erros_validacao)]);
    }

    $pdo->beginTransaction();

    // Inserir produto
    $sqlProdutos = "INSERT INTO Produtos(nome, descricao, preco, tamanho, statusproduto) 
                    VALUES (:nome, :descricao, :preco, :tamanho, :statusproduto)";
    $stmtProduto = $pdo->prepare($sqlProdutos);
    $stmtProduto->execute([
        ":nome" => $nome,
        ":descricao" => $descricao,
        ":preco" => $preco,
        ":tamanho" => $tamanho,
        ":statusproduto" => $statusproduto
    ]);

    $idProduto = (int)$pdo->lastInsertId();

    // Inserir imagens
    $imagens = [
        readImageToBlob($_FILES["imagem1"] ?? null),
        readImageToBlob($_FILES["imagem2"] ?? null),
        readImageToBlob($_FILES["imagem3"] ?? null)
    ];

    $idImagem = null;
    foreach ($imagens as $img) {
        if ($img !== null) {
            $sqlImg = "INSERT INTO Imagem_produtos(foto) VALUES (:foto)";
            $stmtImg = $pdo->prepare($sqlImg);
            $stmtImg->bindParam(":foto", $img, PDO::PARAM_LOB);
            $stmtImg->execute();
            $idImagem = (int)$pdo->lastInsertId();

            // Vincular imagem ao produto
            $sqlVinculo = "INSERT INTO Produtos_has_Imagem_produtos(Produtos_idProdutos, Imagem_produtos_idImagem_produtos)
                           VALUES (:idProduto, :idImagem)";
            $stmtVinculo = $pdo->prepare($sqlVinculo);
            $stmtVinculo->execute([
                ":idProduto" => $idProduto,
                ":idImagem" => $idImagem
            ]);
        }
    }

    $pdo->commit();
    redirecWith("../paginas_logista/cadastro_produtos_logista.html", ["sucesso" => "Produto cadastrado com sucesso"]);

} catch (Exception $e) {
    redirecWith("../paginas_logista/cadastro_produtos_logista.html", ["erro" => "Erro no banco de dados: " . $e->getMessage()]);
}
?>
