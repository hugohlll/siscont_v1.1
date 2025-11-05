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
    $id = (int)$_POST['id'];
    $nome = $_POST['nome'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $senha_confirma = $_POST['senha_confirma'];

    $update_password = false;
    $senha_hash = '';

    // (3) Lógica de Senha
    if (!empty($senha)) {
        if ($senha != $senha_confirma) {
            die("Erro: As senhas digitadas não conferem. <a href='javascript:history.back()'>Voltar</a>");
        }
        // Se as senhas conferem, cria o hash
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $update_password = true;
    }

    try {
        if (empty($id)) {
            // --- MODO CREATE ---
            if (!$update_password) {
                // Senha é obrigatória ao criar
                die("Erro: A senha é obrigatória para criar um novo usuário. <a href='javascript:history.back()'>Voltar</a>");
            }
            $sql = "INSERT INTO usuarios (nome, login, senha_hash) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("sss", $nome, $login, $senha_hash);
            
        } else {
            // --- MODO UPDATE ---
            if ($update_password) {
                // Atualiza TUDO (incluindo senha)
                $sql = "UPDATE usuarios SET nome = ?, login = ?, senha_hash = ? WHERE id = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("sssi", $nome, $login, $senha_hash, $id);
            } else {
                // Atualiza SÓ nome e login (senha fica intacta)
                $sql = "UPDATE usuarios SET nome = ?, login = ? WHERE id = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("ssi", $nome, $login, $id);
            }
        }
        
        $stmt->execute();
        $stmt->close();

    } catch (mysqli_sql_exception $e) {
        // Erro 1062: Entrada duplicada (provavelmente o 'login')
        if ($e->getCode() == 1062) {
             die("Erro: O login '{$login}' já está em uso. <a href='javascript:history.back()'>Voltar</a>");
        }
        die("Erro ao salvar usuário: " . $e->getMessage());
    }
}

// (4) Ação de Excluir (Delete) vinda da URL GET
if (isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
    
    $id = (int)$_GET['id'];

    try {
        // (5) LÓGICA DE SEGURANÇA: Verifica se o usuário não está tentando se auto-excluir
        $sql_check = "SELECT login FROM usuarios WHERE id = ?";
        $stmt_check = $mysqli->prepare($sql_check);
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $usuario_a_excluir = $result_check->fetch_assoc();
        $stmt_check->close();

        if ($usuario_a_excluir && $usuario_a_excluir['login'] == $_SESSION['usuario_logado']) {
            die("Erro: Você não pode excluir sua própria conta enquanto está logado nela. <a href='usuarios_index.php'>Voltar</a>");
        }

        // Se passou na verificação, pode excluir
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

    } catch (mysqli_sql_exception $e) {
        die("Erro ao excluir usuário: " . $e->getMessage());
    }
}

// (6) Redireciona de volta para a lista após a ação
header("Location: usuarios_index.php");
exit;
?>
