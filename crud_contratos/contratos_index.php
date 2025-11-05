<?php
// (1) Inicia a sessão e protege a página
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

include "../conexao.php"; // Conexão

try {
    $sql = "SELECT c.idcont, c.numerocont, c.anocont, c.omcont, c.objeto, c.vigencia_fim, e.nomeempresa 
            FROM contratos c
            JOIN empresas e ON c.idempresa = e.idempresa
            ORDER BY c.anocont DESC, c.numerocont DESC";
            
    $stmt = $mysqli->query($sql);
    $contratos = $stmt->fetch_all(MYSQLI_ASSOC);

} catch (mysqli_sql_exception $e) {
    die("Erro ao consultar contratos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Contratos</title>
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
    
            <h2>Gerenciamento de Contratos</h2>
            
            <p style="margin-bottom: 20px;">
                <a href="contratos_form.php" class="btn-primary-crud">Adicionar Novo Contrato</a>
                <a href="../dashboard.php" class="btn-secondary-crud">Voltar ao Painel</a>
            </p>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Contrato</th>
                        <th>Empresa</th>
                        <th>Objeto</th>
                        <th>Vigência Fim</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contratos as $contrato): ?>
                    <tr>
                        <td><?= $contrato['idcont'] ?></td>
                        <td><?= htmlspecialchars($contrato['numerocont']) ?>/<?= htmlspecialchars($contrato['omcont']) ?>/<?= $contrato['anocont'] ?></td>
                        <td><?= htmlspecialchars($contrato['nomeempresa']) ?></td>
                        <td><?= htmlspecialchars(substr($contrato['objeto'], 0, 70)) ?><?= (strlen($contrato['objeto']) > 70 ? '...' : '') ?></td>
                        <td><?= date('d/m/Y', strtotime($contrato['vigencia_fim'])) ?></td>
                        <td>
                            <a href="contratos_form.php?id=<?= $contrato['idcont'] ?>">Editar</a>
                            |
                            <a href="contratos_acao.php?acao=excluir&id=<?= $contrato['idcont'] ?>" 
                               class="action-delete-link"
                               onclick="return confirm('Tem certeza? Excluir um contrato também excluirá suas comissões associadas!');">
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
