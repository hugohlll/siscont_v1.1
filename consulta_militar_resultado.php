<?php
// (1) NÃO HÁ VERIFICAÇÃO DE SESSÃO AQUI (página pública)

include "conexao.php"; //

$nome_militar = $_POST['nome_militar'];
if (empty($nome_militar)) {
    die("Termo de busca não fornecido.");
}

$comissoes = [];
// (2) O termo de busca é cercado por '%' para o LIKE
$search_term = "%" . $nome_militar . "%";

try {
    // (3) Usamos a VIEW que já tem tudo, filtrando por nome E status 'vigente'
    $sql = "SELECT nome_militar, funcao, contrato, inicio_comissao, fim_comissao 
            FROM VW_MEMBROS_COMISSOES_DETALHES 
            WHERE nome_militar LIKE ? 
            AND status_comissao = 'vigente' 
            ORDER BY nome_militar, inicio_comissao DESC";
    
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
    $comissoes = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $mysqli->close();

} catch (mysqli_sql_exception $e) {
    die("Erro ao consultar o relatório: " . $e->getMessage());
}

$titulo_relatorio = "Comissões Vigentes para: \"" . htmlspecialchars($nome_militar) . "\"";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado - Consulta por Militar</title>
    <link rel="stylesheet" href="estilo.css">
    <style>
        table { width: 100%; margin: 20px auto; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        td { font-size: 0.9em; }
    </style>
</head>
<body>
    <div id="topo">
        <h1>::SISCONT:: (Consulta Pública)</h1>
    </div>
    
    <div id="conteudo" style="padding: 20px;">
        <h2><?= $titulo_relatorio ?></h2>
        <p><a href="consulta_comissao.php">Voltar para a consulta</a></p>

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
                <?php if (count($comissoes) == 0): ?>
                    <tr><td colspan="5">Nenhuma comissão vigente encontrada para este militar.</td></tr>
                <?php endif; ?>

                <?php foreach ($comissoes as $comissao): ?>
                <tr>
                    <td><?= htmlspecialchars($comissao['nome_militar']) ?></td>
                    <td><?= htmlspecialchars($comissao['funcao']) ?></td>
                    <td><?= htmlspecialchars($comissao['contrato']) ?></td>
                    <td><?= date('d/m/Y', strtotime($comissao['inicio_comissao'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($comissao['fim_comissao'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div> <div id="rodape">
    </div>
</body>
</html>
