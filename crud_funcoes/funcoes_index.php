<?php
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

include "../conexao.php";

try {
    $sql = "SELECT * FROM funcoes ORDER BY nomefuncao";
    $stmt = $mysqli->query($sql);
    $funcoes = $stmt->fetch_all(MYSQLI_ASSOC);
} catch (mysqli_sql_exception $e) {
    die("Erro ao consultar Funções: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Funções</title>
    <link rel="stylesheet" href="../estilo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    
    <div id="topo">
        <h1>::SISCONT::</h1>
        <div class="header-fab-info">
            <span>Força Aérea Brasileira</span>
            <img src="../img/gladio_80px.webp" alt="Gládio Alado FAB">
        </div>
    </div>
    
    <div id="conteudo-interno">
        <div class="main-content-card">
    
            <h2>Gerenciamento de Funções</h2>
            
            <p style="margin-bottom: 20px;">
                <a href="funcoes_form.php" class="btn-primary-crud">Adicionar Nova Função</a>
                <a href="../dashboard.php" class="btn-secondary-crud">Voltar ao Painel</a>
            </p>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome da Função (Ex: Fiscal, Membro)</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($funcoes as $funcao): ?>
                    <tr>
                        <td><?= $funcao['idfuncao'] ?></td>
                        <td><?= htmlspecialchars($funcao['nomefuncao']) ?></td>
                        <td>
                            <a href="funcoes_form.php?id=<?= $funcao['idfuncao'] ?>">Editar</a>
                            |
                            <a href="funcoes_acao.php?acao=excluir&id=<?= $funcao['idfuncao'] ?>" 
                               class="action-delete-link"
                               onclick="return confirm('Tem certeza? Militares em comissão podem estar usando esta função.');">
                               Excluir
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        
        </div> </div> <div id="rodape">
        <img src="../img/Dom_Pagl.png" alt="Emblema PAGL" class="footer-logo">
        <div class="footer-text">
            <strong>Prefeitura de Aeronáutica do Galeão</strong>
            &copy; <?= date('Y'); ?> SISCONT. Todos os direitos reservados. | Desenvolvido por: SO Hugo
        </div>
    </div>

</body>
</html>
