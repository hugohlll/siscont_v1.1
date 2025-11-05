<?php
// (1) Inicia a sessão e protege a página
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: index.php");
    exit;
}

include "conexao.php"; // Conexão

$idcont = (int)$_POST['idcont'];
if ($idcont <= 0) {
    die("Contrato inválido.");
}

$comissoes_vigentes = [];
$comissoes_historico = [];
$info_contrato = null;

try {
    // (2) Query 1: Buscar informações do contrato (sem alterações)
    $sql_info = "SELECT numerocont, omcont, anocont, nomeempresa FROM CONTRATOS_LANCADOS_VW WHERE idcont = ?";
    $stmt_info = $mysqli->prepare($sql_info);
    $stmt_info->bind_param("i", $idcont);
    $stmt_info->execute();
    $result_info = $stmt_info->get_result();
    $info_contrato = $result_info->fetch_assoc();
    $stmt_info->close();

    if (!$info_contrato) {
        die("Contrato não encontrado.");
    }

    // (3) Query 2: Buscar comissões 'VIGENTES' (sem alterações)
    $sql_vigentes = "SELECT idcom, tipocom, vigencia_ini, vigencia_fim, portaria_num, portaria_data, bol_num, bol_data FROM comissoes WHERE contratos_idcont = ? AND status = 'vigente' ORDER BY vigencia_ini DESC";
    $stmt_vigentes = $mysqli->prepare($sql_vigentes);
    $stmt_vigentes->bind_param("i", $idcont);
    $stmt_vigentes->execute();
    $result_vigentes = $stmt_vigentes->get_result();
    $comissoes_vigentes = $result_vigentes->fetch_all(MYSQLI_ASSOC);
    $stmt_vigentes->close();


    // (4) Query 3: Buscar comissões 'FINALIZADA' ou 'REVOGADA' (sem alterações)
    $sql_historico = "SELECT idcom, tipocom, status, vigencia_ini, vigencia_fim, portaria_num, portaria_data, bol_num, bol_data FROM comissoes WHERE contratos_idcont = ? AND (status = 'finalizada' OR status = 'revogada') ORDER BY vigencia_fim DESC";
            
    $stmt_historico = $mysqli->prepare($sql_historico);
    $stmt_historico->bind_param("i", $idcont);
    $stmt_historico->execute();
    
    // *** A CORREÇÃO ESTÁ AQUI ***
    // Corrigido de $result_historico para $stmt_historico->get_result()
    $result_historico_query = $stmt_historico->get_result();
    $comissoes_historico = $result_historico_query->fetch_all(MYSQLI_ASSOC);
    
    $stmt_historico->close();

} catch (mysqli_sql_exception $e) {
    die("Erro ao consultar histórico: " . $e->getMessage());
}

$titulo_relatorio = sprintf(
    "Contrato: %s/%s/%s (%s)",
    htmlspecialchars($info_contrato['numerocont']),
    htmlspecialchars($info_contrato['omcont']),
    htmlspecialchars($info_contrato['anocont']),
    htmlspecialchars($info_contrato['nomeempresa'])
);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado - Relatório de Contrato</title>
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
    
            <h2>Relatório de Comissões por Contrato</h2>
            <h3 style="color: #0056b3; font-weight: 500; margin-top: -15px;"><?= $titulo_relatorio ?></h3>
            
            <p style="margin-bottom: 20px;">
                <a href="relatorio_contrato.php" class="btn-secondary-crud">Voltar (Novo Filtro)</a>
                <a href="dashboard.php" class="btn-secondary-crud">Voltar ao Painel</a>
            </p>
            <form action="exportar_relatorio_contrato.php" method="POST" style="margin-bottom: 30px;">
                <input type="hidden" name="idcont" value="<?= $idcont ?>">
                <button type="submit" class="btn-primary-crud" style="background-color: #217346;">
                    Exportar Histórico Completo (CSV)
                </button>
            </form>

            <h3>Comissões Vigentes</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID Comissão</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Portaria</th>
                        <th>Boletim Nº</th>
                        <th>Data Boletim</th>
                        <th>Vigência Início</th>
                        <th>Vigência Fim</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($comissoes_vigentes) == 0): ?>
                        <tr><td colspan="8">Nenhuma comissão vigente encontrada.</td></tr>
                    <?php else: ?>
                        <?php foreach ($comissoes_vigentes as $comissao): ?>
                        <tr>
                            <td><?= $comissao['idcom'] ?></td>
                            <td><?= htmlspecialchars($comissao['tipocom']) ?></td>
                            <td class="status-vigente">Vigente</td>
                            <td><?= htmlspecialchars($comissao['portaria_num']) ?>/<?= date('Y', strtotime($comissao['portaria_data'])) ?></td>
                            <td><?= htmlspecialchars($comissao['bol_num']) ?></td>
                            <td>
                                <?php
                                $ts_bol = strtotime($comissao['bol_data']);
                                if ($ts_bol && $ts_bol > 0) {
                                    echo date('d/m/Y', $ts_bol);
                                } else {
                                    echo 'N/D';
                                }
                                ?>
                            </td>
                            <td><?= date('d/m/Y', strtotime($comissao['vigencia_ini'])) ?></td>
                            <td><?= date('d/m/Y', strtotime($comissao['vigencia_fim'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <h3 style="margin-top: 30px;">Histórico (Comissões Finalizadas e Revogadas)</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID Comissão</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Portaria</th>
                        <th>Boletim Nº</th>
                        <th>Data Boletim</th>
                        <th>Vigência Início</th>
                        <th>Vigência Fim</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($comissoes_historico) == 0): ?>
                        <tr><td colspan="8">Nenhum histórico encontrado.</td></tr>
                    <?php else: ?>
                        <?php foreach ($comissoes_historico as $comissao): ?>
                        <tr>
                            <td><?= $comissao['idcom'] ?></td>
                            <td><?= htmlspecialchars($comissao['tipocom']) ?></td>
                            <td class="status-<?= strtolower($comissao['status']) ?>">
                                <?= htmlspecialchars(ucfirst($comissao['status'])) ?>
                            </td>
                            <td><?= htmlspecialchars($comissao['portaria_num']) ?>/<?= date('Y', strtotime($comissao['portaria_data'])) ?></td>
                            <td><?= htmlspecialchars($comissao['bol_num']) ?></td>
                            <td>
                                <?php
                                $ts_bol = strtotime($comissao['bol_data']);
                                if ($ts_bol && $ts_bol > 0) {
                                    echo date('d/m/Y', $ts_bol);
                                } else {
                                    echo 'N/D';
                                }
                                ?>
                            </td>
                            <td><?= date('d/m/Y', strtotime($comissao['vigencia_ini'])) ?></td>
                            <td><?= date('d/m/Y', strtotime($comissao['vigencia_fim'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            
        </div> </div> <div id="rodape">
        &copy; <?= date('Y'); ?> SISCONT. Todos os direitos reservados. | Desenvolvido por: SO Hugo
    </div>
    
</body>
</html>
