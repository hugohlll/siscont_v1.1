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
    $idcom = (int)$_POST['idcom']; // 0 se for novo
    $tipocom = $_POST['tipocom'];
    $contratos_idcont = (int)$_POST['contratos_idcont'];
    $vigencia_ini = $_POST['vigencia_ini'];
    $vigencia_fim = $_POST['vigencia_fim'];
    $portaria_num = (int)$_POST['portaria_num'];
    $portaria_data = $_POST['portaria_data'];
    $bol_num = (int)$_POST['bol_num'];
    $bol_data = $_POST['bol_data'];
    $obs = $_POST['obs'];
    $status = $_POST['status'];

    try {
        if (empty($idcom)) {
            // --- CREATE ---
            $sql = "INSERT INTO comissoes 
                    (tipocom, contratos_idcont, vigencia_ini, vigencia_fim, portaria_num, portaria_data, bol_num, bol_data, obs, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            // Tipos: s=string, i=int
            $stmt->bind_param("sississsss", 
                $tipocom, $contratos_idcont, $vigencia_ini, $vigencia_fim, $portaria_num, $portaria_data, $bol_num, $bol_data, $obs, $status);
            
        } else {
            // --- UPDATE ---
            $sql = "UPDATE comissoes SET 
                    tipocom = ?, contratos_idcont = ?, vigencia_ini = ?, vigencia_fim = ?, portaria_num = ?, 
                    portaria_data = ?, bol_num = ?, bol_data = ?, obs = ?, status = ? 
                    WHERE idcom = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("sississsssi", 
                $tipocom, $contratos_idcont, $vigencia_ini, $vigencia_fim, $portaria_num, $portaria_data, $bol_num, $bol_data, $obs, $status, 
                $idcom);
        }
        
        $stmt->execute();
        $stmt->close();

    } catch (mysqli_sql_exception $e) {
        die("Erro ao salvar comissão: " . $e->getMessage());
    }
}

// (3) Ação de Excluir (Delete) vinda da URL GET
if (isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
    
    $idcom = (int)$_GET['id'];
    if (empty($idcom)) {
        die("ID inválido para exclusão.");
    }

    // --- LÓGICA DE TRANSAÇÃO PARA EXCLUSÃO SEGURA ---
    $mysqli->begin_transaction(); // Inicia a transação

    try {
        // Passo A: Excluir dependências (militares associados)
        $sql1 = "DELETE FROM militares_has_comissoes WHERE idcom = ?";
        $stmt1 = $mysqli->prepare($sql1);
        $stmt1->bind_param("i", $idcom);
        $stmt1->execute();
        $stmt1->close();
        
        // Passo B: Excluir a comissão principal
        $sql2 = "DELETE FROM comissoes WHERE idcom = ?";
        $stmt2 = $mysqli->prepare($sql2);
        $stmt2->bind_param("i", $idcom);
        $stmt2->execute();
        $stmt2->close();
        
        // Se tudo deu certo, confirma as mudanças
        $mysqli->commit();

    } catch (mysqli_sql_exception $e) {
        // Se algo deu errado, desfaz tudo
        $mysqli->rollback();
        die("Erro ao excluir comissão: " . $e->getMessage());
    }
}

// (4) Redireciona de volta para a lista após a ação
header("Location: comissoes_index.php");
exit;
?>
