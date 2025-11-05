<?php
// (1) Proteção
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

include "../conexao.php"; // Conexão

try {
    $sql = "SELECT 
                c.idcom, c.tipocom, c.status, c.vigencia_fim,
                ct.numerocont, ct.omcont, ct.anocont,
                e.nomeempresa
            FROM comissoes c
            JOIN contratos ct ON c.contratos_idcont = ct.idcont
            JOIN empresas e ON ct.idempresa = e.idempresa
            ORDER BY c.idcom DESC";
            
    $stmt = $mysqli->query($sql);
    $comissoes = $stmt->fetch_all(MYSQLI_ASSOC);

} catch (mysqli_sql_exception $e) {
    die("Erro ao consultar comissões: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Comissões</title>
    <link rel="stylesheet" href="../estilo.css"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Estilos de Status (específico desta página) */
        .status-vigente { color: #27a750; font-weight: bold; }
        .status-finalizada { color: #d9534f; }
        .status-revogada { color: #f0ad4e; }
        .action-membros-link { color: #0275d8 !important; } /* Azul para Gerenciar Membros */
    </style>
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
    
            <h2>Gerenciamento de Comissões</h2>
            
            <p style="margin-bottom: 20px;">
                <a href="comissoes_form.php" class="btn-primary-crud">Adicionar Nova Comissão</a>
                <a href="../dashboard.php" class="btn-secondary-crud">Voltar ao Painel</a>
            </p>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Contrato</th>
                        <th>Empresa</th>
                        <th>Status</th>
                        <th>Vigência Fim</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comissoes as $comissao): ?>
                    <tr>
                        <td><?= $comissao['idcom'] ?></td>
                        <td><?= htmlspecialchars($comissao['tipocom']) ?></td>
                        <td><?= htmlspecialchars($comissao['numerocont']) ?>/<?= htmlspecialchars($comissao['omcont']) ?>/<?= $comissao['anocont'] ?></td>
                        <td><?= htmlspecialchars($comissao['nomeempresa']) ?></td>
                        
                        <td class="status-<?= strtolower($comissao['status']) ?>">
                            <?= htmlspecialchars($comissao['status']) ?>
                        </td>
                        
                        <td><?= date('d/m/Y', strtotime($comissao['vigencia_fim'])) ?></td>
                        <td>
                            <a href="comissoes_form.php?id=<?= $comissao['idcom'] ?>">Editar</a>
                            |
                            <a href="comissao_membros.php?id=<?= $comissao['idcom'] ?>" class="action-membros-link">Membros</a>
                            |
                            <a href="comissoes_acao.php?acao=excluir&id=<?= $comissao['idcom'] ?>" 
                               class="action-delete-link"
                               onclick="return confirm('ATENÇÃO! Excluir uma comissão também removerá todos os militares associados a ela. Deseja continuar?');">
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
