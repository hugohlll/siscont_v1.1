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
    
    $idpg = (int)$_POST['idpg']; // 0 se for novo
    $nomepg = $_POST['nomepg'];
    
    if (empty($nomepg)) {
        die("O nome é obrigatório.");
    }

    try {
        if (empty($idpg)) {
            // --- CREATE ---
            $sql = "INSERT INTO posto_grad (nomepg) VALUES (?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $nomepg);
            
        } else {
            // --- UPDATE ---
            $sql = "UPDATE posto_grad SET nomepg = ? WHERE idpg = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $nomepg, $idpg);
        }
        $stmt->execute();
        $stmt->close();

    } catch (mysqli_sql_exception $e) {
        die("Erro ao salvar: " . $e->getMessage());
    }
}

// (3) Ação de Excluir (Delete) vinda da URL GET
if (isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
    
    $idpg = (int)$_GET['id'];

    try {
        // --- DELETE ---
        $sql = "DELETE FROM posto_grad WHERE idpg = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $idpg);
        $stmt->execute();
        $stmt->close();

    } catch (mysqli_sql_exception $e) {
        // Erro 1451: Violação de Chave Estrangeira (em uso)
        if ($e->getCode() == 1451) {
            echo "<script>
                    alert('Erro: Não é possível excluir. Este Posto/Graduação está em uso por um ou mais militares.');
                    window.location.href = 'posto_grad_index.php';
                  </script>";
            exit; 
        } else {
            die("Erro ao excluir: " . $e->getMessage());
        }
    }
}

// (4) Redireciona de volta para a lista
header("Location: posto_grad_index.php");
exit;
?>
