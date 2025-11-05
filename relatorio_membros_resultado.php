<?php
// (1) Inicia a sessão e protege a página
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: index.php");
    exit;
}

include "conexao.php"; // Conexão

$data_inicio_filtro = $_POST['data_inicio'];
$data_fim_filtro = $_POST['data_fim'];

if (empty($data_inicio_filtro) || empty($data_fim_filtro)) {
    die("Datas inválidas.");
}

$membros_comissoes = [];

try {
    // (2) Lógica da consulta
    $sql = "SELECT 
                nome_militar,
                funcao,
                contrato,
                inicio_comissao,
                fim_comissao
            FROM 
                `VW_MEMBROS_COMISSOES_DETALHES`
            WHERE
                (inicio_comissao <= ?) 
                AND 
                (fim_comissao >= ?)
            ORDER BY
                nome_militar, inicio_comissao";
            
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $data_fim_filtro, $data_inicio_filtro);
    $stmt->execute();
    $result = $stmt->get_result();
    $membros_comissoes = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

} catch (mysqli_sql_exception $e) {
    die("Erro ao consultar o relatório: " . $e->getMessage());
}

$titulo_relatorio = sprintf(
    "Relatório de Militares Ativos entre %s e %s",
    date('d/m/Y', strtotime($data_inicio_filtro)),
    date('d/m/Y', strtotime($data_fim_filtro))
);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado - Relatório de Membros</title>
    <link rel="stylesheet" href="estilo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <a href="relatorio_membros_intervalo.php" class="btn-secondary-crud">Voltar (Novo Filtro)</a>
                <a href="dashboard.php" class="btn-secondary-crud">Voltar ao Painel</a>
            </p>
            
            <form action="exportar_relatorio_membros.php" method="POST" style="margin-bottom: 30px;">
                <input type="hidden" name="data_inicio" value="<?= htmlspecialchars($data_inicio_filtro) ?>">
                <input type="hidden" name="data_fim" value="<?= htmlspecialchars($data_fim_filtro) ?>">
                
                <button type="submit" class="btn-primary-crud" style="background-color: #217346;">
                    Exportar para Excel (CSV)
                </button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Militar</th>
                        <th>Função</th>
                        <th>Contrato</th>
                        <th>Início Comissão</th>
                        <th>Fim Comissão</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($membros_comissoes) == 0): ?>
                        <tr><td colspan="5">Nenhum militar encontrado em comissões ativas neste período.</td></tr>
                    <?php endif; ?>

                    <?php foreach ($membros_comissoes as $membro): ?>
                    <tr>
                        <td><?= htmlspecialchars($membro['nome_militar']) ?></td>
                        <td><?= htmlspecialchars($membro['funcao']) ?></td>
                        <td><?= htmlspecialchars($membro['contrato']) ?></td>
                        <td><?= date('d/m/Y', strtotime($membro['inicio_comissao'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($membro['fim_comissao'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
        </div> </div> <div id="rodape">
        &copy; <?= date('Y'); ?> SISCONT. Todos os direitos reservados. | Desenvolvido por: SO Hugo
    </div>
    
</body>
</html>
