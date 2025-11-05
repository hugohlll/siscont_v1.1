<?php
// (1) Proteção
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

include "../conexao.php"; // Conexão

// (2) Ação de Criar (Create) ou Editar (Update) vinda do POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Coleta os dados
    $idcont = (int)$_POST['idcont']; // 0 se for novo
    $idempresa = (int)$_POST['idempresa'];
    $numerocont = (int)$_POST['numerocont'];
    $vigencia_ini = $_POST['vigencia_ini'];
    $vigencia_fim = $_POST['vigencia_fim'];
    $obs = $_POST['obs'];

    // Trata campos que podem ser NULOS
    $omcont = empty($_POST['omcont']) ? NULL : $_POST['omcont'];
    $anocont = empty($_POST['anocont']) ? NULL : (int)$_POST['anocont'];
    $tipocont = empty($_POST['tipocont']) ? NULL : $_POST['tipocont'];
    $vltotal = empty($_POST['vltotal']) ? NULL : (float)$_POST['vltotal'];
    $objeto = empty($_POST['objeto']) ? NULL : $_POST['objeto'];
    $NUP = empty($_POST['NUP']) ? NULL : $_POST['NUP'];
    
    // Validação básica
    if (empty($idempresa) || empty($numerocont) || empty($vigencia_ini) || empty($vigencia_fim)) {
        die("Campos obrigatórios (Empresa, Número, Vigências) não podem estar vazios.");
    }

    try {
        if (empty($idcont)) {
            // --- CREATE ---
            $sql = "INSERT INTO contratos 
                    (idempresa, numerocont, omcont, anocont, tipocont, vltotal, objeto, NUP, vigencia_ini, vigencia_fim, obs) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            // Tipos: i=int, s=string, d=double(decimal)
            $stmt->bind_param("iisissdssss", 
                $idempresa, $numerocont, $omcont, $anocont, $tipocont, $vltotal, $objeto, $NUP, $vigencia_ini, $vigencia_fim, $obs);
            
        } else {
            // --- UPDATE ---
            $sql = "UPDATE contratos SET 
                    idempresa = ?, numerocont = ?, omcont = ?, anocont = ?, tipocont = ?, vltotal = ?, 
                    objeto = ?, NUP = ?, vigencia_ini = ?, vigencia_fim = ?, obs = ? 
                    WHERE idcont = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("iisissdssssi", 
                $idempresa, $numerocont, $omcont, $anocont, $tipocont, $vltotal, $objeto, $NUP, $vigencia_ini, $vigencia_fim, $obs, 
                $idcont);
        }
        
        $stmt->execute();
        $stmt->close();

    } catch (mysqli_sql_exception $e) {
        die("Erro ao salvar contrato: " . $e->getMessage());
    }
}

// (3) Ação de Excluir (Delete) vinda da URL GET
if (isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
    
    $idcont = (int)$_GET['id'];

    if (empty($idcont)) {
        die("ID inválido para exclusão.");
    }

    try {
        // --- DELETE ---
        // ATENÇÃO: A foreign key na tabela 'comissoes' deve ter 'ON DELETE CASCADE'
        // Se não tiver, você precisa primeiro excluir as comissões manualmente.
        // Assumindo que a exclusão deve falhar se houver comissões (mais seguro).
        $sql = "DELETE FROM contratos WHERE idcont = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $idcont);
        $stmt->execute();
        $stmt->close();

    } catch (mysqli_sql_exception $e) {
        // Erro 1451: Violação de Chave Estrangeira (contrato está em uso)
        if ($e->getCode() == 1451) {
            echo "<script>
                    alert('Erro: Não é possível excluir. Este contrato está em uso por uma ou mais comissões.');
                    window.location.href = 'contratos_index.php';
                  </script>";
            exit; 
        } else {
            die("Erro ao excluir contrato: " . $e->getMessage());
        }
    }
}

// (4) Redireciona de volta para a lista após a ação
header("Location: contratos_index.php");
exit;
?>
