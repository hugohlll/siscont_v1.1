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

try {
    // (2) Executa EXATAMENTE a mesma query da página de resultados
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

    // (3) Define os cabeçalhos (Headers) para forçar o download
    $filename = "relatorio_membros_" . date('Y-m-d') . ".csv";
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // (4) Adiciona o "BOM" - Truque para o Excel (Windows/Português) ler o UTF-8 (acentos) corretamente
    echo "\xEF\xBB\xBF";

    // (5) Abre o "output" do PHP como se fosse um arquivo
    $output = fopen('php://output', 'w');

    // (6) Escreve a linha do Cabeçalho do CSV
    fputcsv($output, [
        'Militar', 
        'Função', 
        'Contrato', 
        'Início Comissão', 
        'Fim Comissão'
    ]);

    // (7) Loop pelos resultados e escreve cada linha no CSV
    while ($row = $result->fetch_assoc()) {
        // Formata as datas para o padrão brasileiro
        $row['inicio_comissao'] = date('d/m/Y', strtotime($row['inicio_comissao']));
        $row['fim_comissao'] = date('d/m/Y', strtotime($row['fim_comissao']));
        
        // Escreve a linha no arquivo
        fputcsv($output, $row);
    }

    // Fecha o "arquivo"
    fclose($output);
    $stmt->close();
    $mysqli->close();
    exit; // Termina o script

} catch (mysqli_sql_exception $e) {
    die("Erro ao gerar exportação: " . $e->getMessage());
}
?>
