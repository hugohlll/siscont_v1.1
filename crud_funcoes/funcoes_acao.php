<?php
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

include "../conexao.php";

// Ação de Criar (Create) ou Editar (Update) vinda do POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $idfuncao = (int)$_POST['idfuncao']; // 0 se for novo
    $nomefuncao = $_POST['nomefuncao'];
    
    if (empty($nomefuncao)) {
        die("O nome da função é obrigatório.");
    }

    try {
        if (empty($idfuncao)) {
            // --- CREATE ---
            $sql = "INSERT INTO funcoes (nomefuncao) VALUES (?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $nomefuncao);
            
        } else {
            // --- UPDATE ---
            $sql = "UPDATE funcoes SET nomefuncao = ? WHERE idfuncao = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $nomefuncao, $idfuncao);
        }
        $stmt->execute();
        $stmt->close();

    } catch (mysqli_sql_exception $e) {
        die("Erro ao salvar: " . $e->getMessage());
    }
}

// Ação de Excluir (Delete) vinda da URL GET
if (isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
    
    $idfuncao = (int)$_GET['id'];

    try {
        // --- DELETE ---
        $sql = "DELETE FROM funcoes WHERE idfuncao = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $idfuncao);
        $stmt->execute();
        $stmt->close();

    } catch (mysqli_sql_exception $e) {
        // Erro 1451: Violação de Chave Estrangeira (em uso)
        if ($e->getCode() == 1451) {
            echo "<script>
                    alert('Erro: Não é possível excluir. Esta função está em uso por um ou mais militares em comissões.');
                    window.location.href = 'funcoes_index.php';
                  </script>";
            exit; 
        } else {
            die("Erro ao excluir: " . $e->getMessage());
        }
    }
}

// Redireciona de volta para a lista
header("Location: funcoes_index.php");
exit;
?>
