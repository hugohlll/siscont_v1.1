<?php
// (1) Inicia a sessão e protege a página
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

include "../conexao.php"; //
$stmt = $mysqli->query("SELECT * FROM empresas ORDER BY nomeempresa");
$empresas = $stmt->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Empresas</title>
    <link rel="stylesheet" href="../estilo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    
    <div id="topo">
        <h1>::SISCONT::</h1>
        <div class="header-fab-info">
            <span>Força Aérea Brasileira</span>
            <img src="../img/gladio_80px.webp" alt="Gládio Alado FAB"> </div>
    </div>
    
    <div id="conteudo-interno">
        <div class="main-content-card">
    
            <h2>Gerenciamento de Empresas</h2>
            
            <p style="margin-bottom: 20px;">
                <a href="empresas_form.php" class="btn-primary-crud">Adicionar Nova Empresa</a>
                <a href="../dashboard.php" class="btn-secondary-crud">Voltar ao Painel</a>
            </p>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome da Empresa</th>
                        <th>CNPJ</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empresas as $empresa): ?>
                    <tr>
                        <td><?= $empresa['idempresa'] ?></td>
                        <td><?= htmlspecialchars($empresa['nomeempresa']) ?></td>
                        <td><?= htmlspecialchars($empresa['CNPJ']) ?></td>
                        <td>
                            <a href="empresas_form.php?id=<?= $empresa['idempresa'] ?>">Editar</a>
                            |
                            <a href="empresas_acao.php?acao=excluir&id=<?= $empresa['idempresa'] ?>" 
                               class="action-delete-link"
                               onclick="return confirm('Tem certeza? Esta empresa pode estar associada a um contrato.');">
                               Excluir
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        
        </div> </div> <div id="rodape">
        <img src="../img/Dom_Pagl.png" alt="Emblema PAGL" class="footer-logo"> <div class="footer-text">
            <strong>Prefeitura de Aeronáutica do Galeão</strong>
            &copy; <?= date('Y'); ?> SISCONT. Todos os direitos reservados. | Desenvolvido por: SO Hugo
        </div>
    </div>

</body>
</html>
