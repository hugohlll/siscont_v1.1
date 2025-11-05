<?php
// (1) Inicia a sessão e protege a página
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: index.php");
    exit;
}

include "conexao.php"; // Conexão

$idmilitar = (int)$_POST['idmilitar'];
if ($idmilitar <= 0) {
    die("Militar inválido.");
}

$comissoes_vigentes = [];
$comissoes_historico = [];
$info_militar = null;

try {
    // (2) Query 1: Buscar informações do militar selecionado (para o título)
    $sql_info = "SELECT m.nomemil, pg.nomepg, m.nomegr 
                 FROM militares m
                 JOIN posto_grad pg ON m.idpg = pg.idpg
                 WHERE m.idmilitar = ?";
    $stmt_info = $mysqli->prepare($sql_info);
    $stmt_info->bind_param("i", $idmilitar);
    $stmt_info->execute();
    $result_info = $stmt_info->get_result();
    $info_militar = $result_info->fetch_assoc();
    $stmt_info->close();

    if (!$info_militar) {
        die("Militar não encontrado.");
    }

    // (3) Query 2: Buscar comissões VIGENTES usando a VIEW
    $sql_vigentes = "SELECT contrato, funcao, inicio_comissao, fim_comissao 
                     FROM VW_MEMBROS_COMISSOES_DETALHES 
                     WHERE idmilitar = ? 
                     AND status_comissao = 'vigente'
                     ORDER BY inicio_comissao DESC";
            
    $stmt_vigentes = $mysqli->prepare($sql_vigentes);
    $stmt_vigentes->bind_param("i", $idmilitar);
    $stmt_vigentes->execute();
    $result_vigentes = $stmt_vigentes->get_result();
    $comissoes_vigentes = $result_vigentes->fetch_all(MYSQLI_ASSOC);
    $stmt_vigentes->close();

    // (4) Query 3: Buscar comissões FINALIZADAS ou REVOGADAS
    $sql_historico = "SELECT contrato, funcao, inicio_comissao, fim_comissao, status_comissao
                      FROM VW_MEMBROS_COMISSOES_DETALHES 
                      WHERE idmilitar = ? 
                      AND (status_comissao = 'finalizada' OR status_comissao = 'revogada')
                      ORDER BY fim_comissao DESC";
            
    $stmt_historico = $mysqli->prepare($sql_historico);
    $stmt_historico->bind_param("i", $idmilitar);
    $stmt_historico->execute();
    $result_historico = $stmt_historico->get_result();
    $comissoes_historico = $result_historico->fetch_all(MYSQLI_ASSOC);
    $stmt_historico->close();


} catch (mysqli_sql_exception $e) {
    die("Erro ao consultar o relatório: " . $e->getMessage());
}

$titulo_relatorio = sprintf(
    "Relatório de Comissões: %s %s",
    htmlspecialchars($info_militar['nomepg']),
    htmlspecialchars($info_militar['nomemil'])
);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado - Relatório de Militar</title>
    <link rel="stylesheet" href="estilo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .status-finalizada { color: #d9534f; }
        .status-revogada { color: #f0ad4e; }
        .status-vigente { color: #27a750; font-weight: bold; }
    </style>
</head>
<body>
    
    <div id="topo">
        <h1>::SISCONT::</h1>
        <div style="position: absolute; top: 22px; right: 30px; color: #ecf0f1;">
            Olá, <strong><?= htmlspecialchars($_SESSION['usuario_logado']); ?></strong>! 
            <a href="logout.php" style="color: #fff; text-decoration: underline; margin-left: 15px;">(Sair)</a>
        </div>
    </div>
    
    <div id="conteudo-interno">
        <div class="main-content-card">
    
            <h2><?= htmlspecialchars($titulo_relatorio) ?></h2>
            
            <p style="margin-bottom: 20px;">
                <a href="relatorio_militar.php" class="btn-secondary-crud">Voltar (Novo Filtro)</a>
                <a href="dashboard.php" class="btn-secondary-crud">Voltar ao Painel</a>
            </p>
            
            <form action="exportar_relatorio_militar.php" method="POST" style="margin-bottom: 30px;">
                <input type="hidden" name="idmilitar" value="<?= $idmilitar ?>">
                <button type="submit" class="btn-primary-crud" style="background-color: #217346;">
                    Exportar Histórico Completo (CSV)
                </button>
            </form>

            <h3>Comissões Vigentes</h3>
            <table>
                <thead>
                    <tr>
                        <th>Contrato</th>
                        <th>Função</th>
                        <th>Início Comissão</th>
                        <th>Fim Comissão</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($comissoes_vigentes) == 0): ?>
                        <tr><td colspan="4">Nenhuma comissão vigente encontrada.</td></tr>
                    <?php endif; ?>

                    <?php foreach ($comissoes_vigentes as $comissao): ?>
                    <tr>
                        <td><?= htmlspecialchars($comissao['contrato']) ?></td>
                        <td><?= htmlspecialchars($comissao['funcao']) ?></td>
                        <td><?= date('d/m/Y', strtotime($comissao['inicio_comissao'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($comissao['fim_comissao'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h3 style="margin-top: 30px;">Histórico (Comissões Finalizadas e Revogadas)</h3>
            <table>
                <thead>
                    <tr>
                        <th>Contrato</th>
                        <th>Função</th>
                        <th>Início Comissão</th>
                        <th>Fim Comissão</th>
                        <th>Status Final</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($comissoes_historico) == 0): ?>
                        <tr><td colspan="5">Nenhum histórico encontrado.</td></tr>
                    <?php endif; ?>

                    <?php foreach ($comissoes_historico as $comissao): ?>
                    <tr>
                        <td><?= htmlspecialchars($comissao['contrato']) ?></td>
                        <td><?= htmlspecialchars($comissao['funcao']) ?></td>
                        <td><?= date('d/m/Y', strtotime($comissao['inicio_comissao'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($comissao['fim_comissao'])) ?></td>
                        <td class="status-<?= strtolower($comissao['status_comissao']) ?>">
                            <?= htmlspecialchars(ucfirst($comissao['status_comissao'])) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div> </div> <div id="rodape">
        &copy; <?= date('Y'); ?> SISCONT. Todos os direitos reservados. | Desenvolvido por: SO Hugo
    </div>
    
</body>
</html>
