<?php
// (1) Inicia a sessão e protege a página
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: index.php");
    exit;
}

include "conexao.php"; // Conexão

// (2) *** REMOVIDO *** O Array de meses não é mais necessário
// $meses = [...];

$idcont = (int)$_POST['idcont'];
if ($idcont <= 0) {
    die("Contrato inválido.");
}

try {
    // (Query 1: Pega o nome do contrato)
    $sql_info = "SELECT numerocont, omcont, anocont FROM CONTRATOS_LANCADOS_VW WHERE idcont = ?";
    $stmt_info = $mysqli->prepare($sql_info);
    $stmt_info->bind_param("i", $idcont);
    $stmt_info->execute();
    $result_info = $stmt_info->get_result();
    $info_contrato = $result_info->fetch_assoc();
    
    $nome_arquivo_ct = preg_replace('/[^A-Za-z0-9_]+/', '', $info_contrato['numerocont'] . "_" . $info_contrato['omcont']);
    $stmt_info->close();

    // (Query 2: Pega TODO O HISTÓRICO)
    $sql_historico_completo = "SELECT idcom, tipocom, status, vigencia_ini, vigencia_fim, portaria_num, portaria_data, bol_num, bol_data
                               FROM comissoes 
                               WHERE contratos_idcont = ? 
                               ORDER BY vigencia_ini DESC";
            
    $stmt_historico = $mysqli->prepare($sql_historico_completo);
    $stmt_historico->bind_param("i", $idcont);
    $stmt_historico->execute();
    $result_historico = $stmt_historico->get_result();

    // (Headers para download)
    $filename = "historico_contrato_" . $nome_arquivo_ct . "_" . date('Y-m-d') . ".csv";
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    echo "\xEF\xBB\xBF";
    $output = fopen('php://output', 'w');

    // (3) Escreve o Cabeçalho do CSV (Colunas atualizadas)
    fputcsv($output, [
        'ID Comissao', 
        'Tipo', 
        'Status', 
        'Portaria Num',
        'Portaria Data',
        'Boletim Num', // (MUDANÇA)
        'Boletim Data', // (MUDANÇA)
        'Início Vigência', 
        'Fim Vigência'
    ]);

    // (4) Loop pelos resultados (Colunas atualizadas)
    while ($row = $result_historico->fetch_assoc()) {
        
        // Formatação de data segura
        $ts_bol = strtotime($row['bol_data']);
        $bol_data_formatada = ($ts_bol && $ts_bol > 0) ? date('d/m/Y', $ts_bol) : 'N/D';

        $linha_csv = [
            'idcom' => $row['idcom'],
            'tipocom' => $row['tipocom'],
            'status' => $row['status'],
            'portaria_num' => $row['portaria_num'],
            'portaria_data' => date('d/m/Y', strtotime($row['portaria_data'])),
            'bol_num' => $row['bol_num'], // (MUDANÇA)
            'bol_data' => $bol_data_formatada, // (MUDANÇA)
            'vigencia_ini' => date('d/m/Y', strtotime($row['vigencia_ini'])),
            'vigencia_fim' => date('d/m/Y', strtotime($row['vigencia_fim']))
        ];
        
        fputcsv($output, $linha_csv);
    }

    // (5) Fecha tudo
    fclose($output);
    $stmt_historico->close();
    $mysqli->close();
    exit;

} catch (mysqli_sql_exception $e) {
    die("Erro ao gerar exportação: " . $e->getMessage());
}
?>
