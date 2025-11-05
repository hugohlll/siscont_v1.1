<?php
// Não precisa de verificação de login, pois a consulta é pública
include "conexao.php";

// Pega o termo de busca vindo do Select2 (via AJAX)
$termo_busca = $_GET['term'] ?? '';

// Se o termo for muito curto, não busca
if (strlen($termo_busca) < 2) {
    echo json_encode([]);
    exit;
}

$search = "%" . $termo_busca . "%";
$resultados = [];

try {
    // Esta é a query que alimenta o Select2.
    // Ela precisa retornar 'id' (o valor que será enviado) e 'text' (o que será exibido)
    $sql = "SELECT 
                CONCAT(c.numerocont, '/', c.omcont, '/', c.anocont) AS id, 
                CONCAT(e.nomeempresa, ' - ', c.numerocont, '/', c.omcont, '/', c.anocont) AS text
            FROM contratos c
            INNER JOIN empresas e ON c.idempresa = e.idempresa
            WHERE 
                e.nomeempresa LIKE ? 
                OR c.numerocont LIKE ? 
                OR c.anocont LIKE ?
            LIMIT 15"; // Limita a 15 resultados para ser rápido
            
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss", $search, $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();
    $resultados = $result->fetch_all(MYSQLI_ASSOC);

} catch (mysqli_sql_exception $e) {
    // Em caso de erro, retorna um JSON de erro (útil para depuração)
    header("Content-Type: application/json");
    http_response_code(500); // Erro interno do servidor
    echo json_encode(['erro' => $e->getMessage()]);
    exit;
}

// Retorna os dados em formato JSON
header("Content-Type: application/json");
echo json_encode($resultados);
?>
