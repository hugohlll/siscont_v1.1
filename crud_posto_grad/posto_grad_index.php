<?php
// (1) Inicia a sessão e protege a página
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

include "../conexao.php"; // Inclui a conexão

try {
    $sql = "SELECT * FROM posto_grad ORDER BY nomepg";
    $stmt = $mysqli->query($sql);
    $postos = $stmt->fetch_all(MYSQLI_ASSOC);
} catch (mysqli_sql_exception $e) {
    die("Erro ao consultar Postos/Graduações: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Postos/Graduações</title>
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
    
            <h2>Gerenciamento de Postos/Graduações</h2>
            
            <p style="margin-bottom: 20px;">
                <a href="posto_grad_form.php" class="btn-primary-crud">Adicionar Novo Posto/Grad</a>
                <a href="../dashboard.php" class="btn-secondary-crud">Voltar ao Painel</a>
            </p>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome (Ex: 1S, 2T, Cap)</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($postos as $posto): ?>
                    <tr>
                        <td><?= $posto['idpg'] ?></td>
                        <td><?= htmlspecialchars($posto['nomepg']) ?></td>
                        <td>
                            <a href="posto_grad_form.php?id=<?= $posto['idpg'] ?>">Editar</a>
                            |
                            <a href="posto_grad_acao.php?acao=excluir&id=<?= $posto['idpg'] ?>" 
                               class="action-delete-link"
                               onclick="return confirm('Tem certeza? Militares podem estar usando este posto.');">
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
