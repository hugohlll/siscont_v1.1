<?php
// (1) Proteção
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

include "../conexao.php"; // Conexão

$idcom = 0; // Inicializa para garantir que temos um ID para redirecionar

try {
    // (2) Ação de ADICIONAR (Create) vinda do formulário POST
    if (isset($_POST['acao']) && $_POST['acao'] == 'adicionar') {
        
        $idcom = (int)$_POST['idcom'];
        $idmilitar = (int)$_POST['idmilitar'];
        $idfuncao = (int)$_POST['idfuncao'];
        
        if ($idcom <= 0 || $idmilitar <= 0 || $idfuncao <= 0) {
            die("Dados inválidos para adicionar membro.");
        }

        $sql = "INSERT INTO militares_has_comissoes (idcom, idmilitar, idfuncao) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("iii", $idcom, $idmilitar, $idfuncao);
        $stmt->execute();
        $stmt->close();

    // (3) Ação de EXCLUIR (Delete) vinda da URL GET
    } elseif (isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
        
        $idcom = (int)$_GET['idcom'];
        $idmilitar = (int)$_GET['idmilitar'];

        if ($idcom <= 0 || $idmilitar <= 0) {
            die("Dados inválidos para excluir membro.");
        }
        
        // A chave primária é (idcom, idmilitar), então precisamos dos dois.
        $sql = "DELETE FROM militares_has_comissoes WHERE idcom = ? AND idmilitar = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ii", $idcom, $idmilitar);
        $stmt->execute();
        $stmt->close();
    }

} catch (mysqli_sql_exception $e) {
    // Erro 1062: "Duplicate entry". Acontece se tentar adicionar o mesmo militar duas vezes.
    if ($e->getCode() == 1062) {
        echo "<script>
                alert('Erro: Este militar já está nesta comissão.');
                window.location.href = 'comissao_membros.php?id=" . $idcom . "';
              </script>";
        exit;
    } else {
        die("Erro no banco de dados: " . $e->getMessage());
    }
}

// (4) Redireciona de volta para a página de gerenciamento de membros
if ($idcom > 0) {
    header("Location: comissao_membros.php?id=" . $idcom);
} else {
    // Fallback, caso algo dê muito errado
    header("Location: comissoes_index.php");
}
exit;
?>
