<?php
// API endpoint para Select2, retorna idmilitar (INT) como valor
session_start();
include "conexao.php"; 

// Protege o endpoint, já que os relatórios são internos
if (!isset($_SESSION['usuario_logado'])) {
    http_response_code(403); // Forbidden
    echo json_encode(['erro' => 'Acesso negado']);
    exit;
}

$termo_busca = $_GET['term'] ?? '';

// Só busca após 2 caracteres
if (strlen($termo_busca) < 2) {
    echo json_encode([]);
    exit;
}

$search = "%" . $termo_busca . "%";
$resultados = [];

try {
    // A query deve retornar 'id' (idmilitar) e 'text' (formato de exibição)
    $sql = "SELECT 
                m.idmilitar AS id, 
                CONCAT('(', pg.nomepg, ') ', m.nomegr, ' - [', m.nomemil, ']') AS text
            FROM militares m
            INNER JOIN posto_grad pg ON m.idpg = pg.idpg
            WHERE 
                m.nomegr LIKE ? 
                OR m.nomemil LIKE ?
            ORDER BY 
                pg.idpg, m.nomegr
            LIMIT 15";
            
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $search, $search); // Busca por nome de guerra ou nome completo
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
