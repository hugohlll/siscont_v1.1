<?php
include "../conexao.php"; //

// Ação de Criar (Create) ou Editar (Update) vinda do formulário POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nomeempresa = $_POST['nomeempresa'];
    $cnpj = $_POST['CNPJ'];
    $idempresa = (int)$_POST['idempresa'];

    try {
        if (empty($idempresa)) {
            // --- CREATE ---
            $sql = "INSERT INTO empresas (nomeempresa, CNPJ) VALUES (?, ?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", $nomeempresa, $cnpj);
            
        } else {
            // --- UPDATE ---
            $sql = "UPDATE empresas SET nomeempresa = ?, CNPJ = ? WHERE idempresa = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ssi", $nomeempresa, $cnpj, $idempresa);
        }
        $stmt->execute();

    } catch (mysqli_sql_exception $e) {
        die("Erro ao salvar empresa: " . $e->getMessage());
    }
}

// Ação de Excluir (Delete) vinda da URL GET
if (isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
    
    $id = (int)$_GET['id'];

    try {
        // --- DELETE ---
        $sql = "DELETE FROM empresas WHERE idempresa = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

    } catch (mysqli_sql_exception $e) {
        // Erro 1451: Violação de Foreign Key
        if ($e->getCode() == 1451) {
            die("Erro: Não é possível excluir. Esta empresa está em uso em um contrato.");
        } else {
            die("Erro ao excluir empresa: " . $e->getMessage());
        }
    }
}

// Redireciona de volta para a lista em ambos os casos (sucesso)
header("Location: empresas_index.php");
exit;
?>
