<?php
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

include "../conexao.php";

$funcao = [
    'idfuncao' => '',
    'nomefuncao' => ''
];
$titulo = "Adicionar Nova Função";

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $titulo = "Editar Função";
    
    try {
        $sql = "SELECT * FROM funcoes WHERE idfuncao = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $funcao = $result->fetch_assoc();
        } else {
            die("Função não encontrada.");
        }
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        die("Erro: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?></title>
    <link rel="stylesheet" href="../estilo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    
    <div id="topo">
        <h1>::SISCONT::</h1>
        <div style="position: absolute; top: 22px; right: 30px; color: #ecf0f1;">
            Olá, <strong><?= htmlspecialchars($_SESSION['usuario_logado']); ?></strong>! 
            <a href="../logout.php" style="color: #fff; text-decoration: underline; margin-left: 15px;">(Sair)</a>
        </div>
    </div>
    
    <div id="conteudo-interno">
        <div class="main-content-card">
    
            <h2><?= $titulo ?></h2>
            
            <form action="funcoes_acao.php" method="POST">
                <input type="hidden" name="idfuncao" value="<?= $funcao['idfuncao'] ?>">
                
                <div class="form-group">
                    <label for="nomefuncao">Nome da Função (Ex: Fiscal):</label>
                    <input type="text" id="nomefuncao" name="nomefuncao" 
                           value="<?= htmlspecialchars($funcao['nomefuncao']) ?>" 
                           maxlength="45" required>
                </div>

                <div class="form-actions">
                    <button type="submit">Salvar</button>
                    <a href="funcoes_index.php" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        
        </div> </div> <div id="rodape">
        &copy; <?= date('Y'); ?> SISCONT. Todos os direitos reservados.
    </div>

</body>
</html>
