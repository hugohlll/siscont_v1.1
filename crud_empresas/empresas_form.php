<?php
// (1) Proteção
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

include "../conexao.php"; // Conexão

$empresa = [
    'idempresa' => '',
    'nomeempresa' => '',
    'CNPJ' => ''
];
$titulo = "Adicionar Nova Empresa";

// Modo Edição
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $titulo = "Editar Empresa";
    
    try {
        $stmt = $mysqli->prepare("SELECT * FROM empresas WHERE idempresa = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $empresa = $result->fetch_assoc();
        } else {
            die("Empresa não encontrada.");
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
            
            <form action="empresas_acao.php" method="POST">
                <input type="hidden" name="idempresa" value="<?= $empresa['idempresa'] ?>">
                
                <div class="form-group">
                    <label for="nomeempresa">Nome da Empresa:</label>
                    <input type="text" id="nomeempresa" name="nomeempresa" 
                           value="<?= htmlspecialchars($empresa['nomeempresa']) ?>" 
                           required>
                </div>
                
                <div class="form-group">
                    <label for="CNPJ">CNPJ:</label>
                    <input type="text" id="CNPJ" name="CNPJ" 
                           value="<?= htmlspecialchars($empresa['CNPJ']) ?>">
                </div>

                <div class="form-actions">
                    <button type="submit">Salvar</button>
                    <a href="empresas_index.php" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        
        </div> </div> <div id="rodape">
        &copy; <?= date('Y'); ?> SISCONT. Todos os direitos reservados.
    </div>

</body>
</html>
