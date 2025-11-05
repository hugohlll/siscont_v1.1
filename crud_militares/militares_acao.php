<?php
// (1) Inicia a sessão e protege
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

include "../conexao.php"; // Conexão

// (2) Ação de Criar (Create) ou Editar (Update) vinda do formulário POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Coleta os dados
    $idmilitar = (int)$_POST['idmilitar']; // 0 se for novo
    $idpg = (int)$_POST['idpg'];
    $nomemil = $_POST['nomemil'];
    $nomegr = $_POST['nomegr'];
    
    // Validação básica
    if (empty($nomemil) || empty($idpg)) {
        die("Nome e Posto/Graduação são obrigatórios.");
    }

    try {
        if (empty($idmilitar)) {
            // --- CREATE ---
            $sql = "INSERT INTO militares (idpg, nomemil, nomegr) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("iss", $idpg, $nomemil, $nomegr);
            
        } else {
            // --- UPDATE ---
            $sql = "UPDATE militares SET idpg = ?, nomemil = ?, nomegr = ? WHERE idmilitar = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("issi", $idpg, $nomemil, $nomegr, $idmilitar);
        }
        
        $stmt->execute();
        $stmt->close();

    } catch (mysqli_sql_exception $e) {
        die("Erro ao salvar militar: " . $e->getMessage());
    }
}

// (3) Ação de Excluir (Delete) vinda da URL GET
if (isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
    
    $idmilitar = (int)$_GET['id'];

    if (empty($idmilitar)) {
        die("ID inválido para exclusão.");
    }

    try {
        // --- DELETE ---
        $sql = "DELETE FROM militares WHERE idmilitar = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $idmilitar);
        $stmt->execute();
        $stmt->close();

    } catch (mysqli_sql_exception $e) {
        // Erro 1451: Violação de Chave Estrangeira (militar está em uso)
        if ($e->getCode() == 1451) {
            echo "<script>
                    alert('Erro: Não é possível excluir este militar, pois ele está associado a uma ou mais comissões.');
                    window.location.href = 'militares_index.php';
                  </script>";
            exit; // Para o script aqui
        } else {
            die("Erro ao excluir militar: " . $e->getMessage());
        }
    }
}

// (4) Redireciona de volta para a lista após a ação
header("Location: militares_index.php");
exit;
?>
