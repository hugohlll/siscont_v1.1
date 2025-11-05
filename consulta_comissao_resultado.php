<?php
// (1) BLOCO DE SESSÃO REMOVIDO PARA ACESSO PÚBLICO
// session_start();
// if (!isset($_SESSION['usuario_logado'])) {
//    header("Location: index.php");
//    exit;
// }

include "conexao.php"; //

$tipo = $_POST['tipocom'];
$contrato = $_POST['contrato'];
$status = $_POST['status'];

// --- (Todo o seu código de consulta PHP vem aqui, ele está correto) ---
// --- Query 1: Obter o idcom (COM PREPARED STATEMENT) ---
$qidcom = "SELECT CI.id, C.status 
           FROM COM_INTEG_AGRUP_1 as CI, comissoes as C 
           WHERE CI.id=C.idcom AND C.status=? AND CI.tipo=? AND CI.contrato=?;"; // Usamos '?'

// Preparar a query
$stmt0 = $mysqli->prepare($qidcom);
$stmt0->bind_param("sss", $status, $tipo, $contrato);
$stmt0->execute();
$result0 = $stmt0->get_result();
$row = $result0->fetch_array(MYSQLI_ASSOC);
$idcom = $row['id'] ?? null; 

$portaria = "N/D";
$boletim = "N/D";
$vigencia = "N/D";

if ($idcom) {
    // --- Query 2: Obter Portaria e Boletim ---
    $qpb = "SELECT CONCAT(portaria_num,'/ACI, de ', DATE_FORMAT(portaria_data, '%d/%m/%Y')) portaria,
                   CONCAT(bol_num,', de ', date_format(bol_data,'%d/%m/%Y')) boletim, 
                   DATE_FORMAT(vigencia_fim, '%d/%m/%Y') vigencia
            FROM comissoes WHERE idcom=?;";
    
    $stmt1 = $mysqli->prepare($qpb);
    $stmt1->bind_param("i", $idcom);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $row1 = $result1->fetch_array(MYSQLI_ASSOC);
    
    if ($row1) {
        $portaria = $row1['portaria'];
        $boletim = $row1['boletim'];
        $vigencia = $row1['vigencia'];
    }

    // --- Query 3: Obter Integrantes ---
    $qint = "SELECT concat(nomepg, ' ', nomegr) militar, nomefuncao funcao 
             FROM COMISSOES_INTEGRANTES WHERE idcom=?
             ORDER BY idcom, idfuncao;";
    
    $stmt2 = $mysqli->prepare($qint);
    $stmt2->bind_param("i", $idcom);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
} 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Consulta</title>
    <link rel="stylesheet" href="estilo.css">
    <style>
        table { width: 90%; margin: 20px auto; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div id="topo">
        <h1>::SISCONT:: (Consulta Pública)</h1>
    </div>

    <div id="conteudo" style="padding: 20px;">
        <h1>Resultado da Consulta</h1>
        
        <table>
            <tr>
                <th colspan="2">COMISSÃO DE <?php echo "<strong>" . htmlspecialchars($tipo) . "</strong>"; ?></th>
            </tr>
            <tr>
                <th colspan="2">CONTRATO <?php echo "<strong>" . htmlspecialchars($contrato) . "</strong>"; ?></th>
            </tr>
        </table>
        <table>
            <tr>
                <td>Portaria</td>
                <td>Boletim</td>
                <td>Vigência</td>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($portaria); ?></td>
                <td><?php echo htmlspecialchars($boletim); ?></td>
                <td><?php echo htmlspecialchars($vigencia); ?></td>
            </tr>
        </table>
        
        <?php if ($idcom && $result2->num_rows > 0): ?>
            <table>
                <tr>
                    <td>MILITAR</td>
                    <td>FUNÇÃO</td>
                </tr>
                <?php
                while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {   
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row2['militar']) . "</td>";
                    echo "<td>" . htmlspecialchars($row2['funcao']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        <?php elseif ($idcom): ?>
            <p style="text-align: center;">Nenhum integrante encontrado para esta comissão.</p>
        <?php else: ?>
            <p style="text-align: center;">Nenhuma comissão encontrada com os filtros selecionados.</p>
        <?php endif; ?>
        
        <br>
        <p style="text-align: center;"><a href="consulta_comissao.php">Voltar para a consulta</a></p>
        <p style="text-align: center;"><a href="index.php">Voltar ao Login</a></p>
    
    </div> <div id="rodape">
    </div>
</body>
</html>
