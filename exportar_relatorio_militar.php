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

try {
    // (2) Query 1: Pega o nome do militar para o nome do arquivo
    $sql_info = "SELECT m.nomegr, pg.nomepg 
                 FROM militares m
                 JOIN posto_grad pg ON m.idpg = pg.idpg
                 WHERE m.idmilitar = ?";
    $stmt_info = $mysqli->prepare($sql_info);
    $stmt_info->bind_param("i", $idmilitar);
    $stmt_info->execute();
    $result_info = $stmt_info->get_result();
    $info_militar = $result_info->fetch_assoc();
    
    // Formata o nome do militar para o nome do arquivo (ex: SO_AZEREDO)
    $nome_arquivo_militar = preg_replace('/[^A-Za-z0-9_]+/', '', $info_militar['nomepg'] . "_" . $info_militar['nomegr']);
    $stmt_info->close();

    // (3) Query 2: Pega TODO O HISTÓRICO (sem filtro de status)
    $sql_historico_completo = "SELECT contrato, funcao, inicio_comissao, fim_comissao, status_comissao
                               FROM VW_MEMBROS_COMISSOES_DETALHES 
                               WHERE idmilitar = ? 
                               ORDER BY inicio_comissao DESC";
            
    $stmt_historico = $mysqli->prepare($sql_historico_completo);
    $stmt_historico->bind_param("i", $idmilitar);
    $stmt_historico->execute();
    $result_historico = $stmt_historico->get_result();

    // (4) Define os cabeçalhos (Headers) para forçar o download
    $filename = "historico_" . $nome_arquivo_militar . "_" . date('Y-m-d') . ".csv";
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // (5) Adiciona o "BOM" para o Excel ler acentos (UTF-8)
    echo "\xEF\xBB\xBF";

    // (6) Abre o "output" do PHP
    $output = fopen('php://output', 'w');

    // (7) Escreve o Cabeçalho do CSV
    fputcsv($output, [
        'Contrato', 
        'Função', 
        'Início Comissão', 
        'Fim Comissão', 
        'Status'
    ]);

    // (8) Loop pelos resultados e escreve cada linha no CSV
    while ($row = $result_historico->fetch_assoc()) {
        // Formata as datas
        $row['inicio_comissao'] = date('d/m/Y', strtotime($row['inicio_comissao']));
        $row['fim_comissao'] = date('d/m/Y', strtotime($row['fim_comissao']));
        
        // Escreve a linha
        fputcsv($output, $row);
    }

    // (9) Fecha tudo
    fclose($output);
    $stmt_historico->close();
    $mysqli->close();
    exit;

} catch (mysqli_sql_exception $e) {
    die("Erro ao gerar exportação: " . $e->getMessage());
}
?>
