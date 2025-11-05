<?php
include "conexao.php"; //

$tipo = $_POST['tipocom'];
$contrato = $_POST['contrato'];
$status = $_POST['status'];

// --- Query 1: Obter o idcom (COM PREPARED STATEMENT) ---
$qidcom = "SELECT CI.id, C.status 
           FROM COM_INTEG_AGRUP_1 as CI, comissoes as C 
           WHERE CI.id=C.idcom AND C.status=? AND CI.tipo=? AND CI.contrato=?;"; // Usamos '?'

// Preparar a query
$stmt0 = $mysqli->prepare($qidcom);
// "sss" significa que estamos passando 3 variáveis do tipo String
$stmt0->bind_param("sss", $status, $tipo, $contrato);
// Executar
$stmt0->execute();
$result0 = $stmt0->get_result();
$row = $result0->fetch_array(MYSQLI_ASSOC);
$idcom = $row['id'] ?? null; // Usamos '?? null' para evitar erros se não houver resultado

$portaria = "N/D";
$boletim = "N/D";
$vigencia = "N/D";

// --- Query 2 e 3 (Só executam se o $idcom foi encontrado) ---
if ($idcom) {
    // --- Query 2: Obter Portaria e Boletim (COM PREPARED STATEMENT) ---
    $qpb = "SELECT CONCAT(portaria_num,'/ACI, de ', DATE_FORMAT(portaria_data, '%d/%m/%Y')) portaria,
                   CONCAT(bol_num,', de ', date_format(bol_data,'%d/%m/%Y')) boletim, 
                   DATE_FORMAT(vigencia_fim, '%d/%m/%Y') vigencia
            FROM comissoes WHERE idcom=?;"; // Usamos '?'
    
    $stmt1 = $mysqli->prepare($qpb);
    $stmt1->bind_param("i", $idcom); // "i" significa que estamos passando 1 Inteiro
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $row1 = $result1->fetch_array(MYSQLI_ASSOC);
    
    $portaria = $row1['portaria'];
    $boletim = $row1['boletim'];
    $vigencia = $row1['vigencia'];

    // --- Query 3: Obter Integrantes (COM PREPARED STATEMENT) ---
    $qint = "SELECT concat(nomepg, ' ', nomegr) militar, nomefuncao funcao 
             FROM COMISSOES_INTEGRANTES WHERE idcom=?
             ORDER BY idcom, idfuncao;"; // Usamos '?'
    
    $stmt2 = $mysqli->prepare($qint);
    $stmt2->bind_param("i", $idcom);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

} // fim do if($idcom)

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Resultado da Consulta</title>
</head>
<body>
    <h1>Resultado da Consulta</h1>
    
    <table align="center">
        <tr>
            <th colspan="2">COMISSÃO DE <?php echo "<strong>" . htmlspecialchars($tipo) . "</strong>"; ?></th>
        </tr>
        <tr>
            <th colspan="2">CONTRATO <?php echo "<strong>" . htmlspecialchars($contrato) . "</strong>"; ?></th>
        </tr>
    </table>
    <table align="center">
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
        <table align="center" border="1">
            <tr>
                <td>MILITAR</td>
                <td>FUNÇÃO</td>
            </tr>
            <?php
            // Loop while para os integrantes
            while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {   
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row2['militar']) . "</td>";
                echo "<td>" . htmlspecialchars($row2['funcao']) . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    <?php elseif ($idcom): ?>
        <p align="center">Nenhum integrante encontrado para esta comissão.</p>
    <?php else: ?>
        <p align="center">Nenhuma comissão encontrada com os filtros selecionados.</p>
    <?php endif; ?>
    
    <br>
    <p align="center"><a href="comissao.php">Voltar para a consulta</a></p>
</body>
</html>
