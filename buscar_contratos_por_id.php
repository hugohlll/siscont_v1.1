<?php
// API endpoint para Select2, retorna idcont (INT) como valor
include "conexao.php"; 

$termo_busca = $_GET['term'] ?? '';

// Só busca após 2 caracteres
if (strlen($termo_busca) < 2) {
    echo json_encode([]);
    exit;
}

$search = "%" . $termo_busca . "%";
$resultados = [];

try {
    // A query agora retorna c.idcont AS id
    $sql = "SELECT 
                c.idcont AS id,  -- <<< A MUDANÇA PRINCIPAL ESTÁ AQUI
                CONCAT(e.nomeempresa, ' - ', c.numerocont, '/', c.omcont, '/', c.anocont) AS text
            FROM contratos c
            INNER JOIN empresas e ON c.idempresa = e.idempresa
            WHERE 
                e.nomeempresa LIKE ? 
                OR c.numerocont LIKE ? 
                OR c.anocont LIKE ?
            LIMIT 15"; // Limita os resultados
            
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss", $search, $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();
    $resultados = $result->fetch_all(MYSQLI_ASSOC);

} catch (mysqli_sql_exception $e) {
    header("Content-Type: application/json");
    http_response_code(500); // Erro interno do servidor
    echo json_encode(['erro' => $e->getMessage()]);
    exit;
}

// Retorna os dados em formato JSON
header("Content-Type: application/json");
echo json_encode($resultados);
?>
