<?php
// (1) Proteção
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

include "../conexao.php"; // Conexão

$usuario = [
    'id' => '',
    'nome' => '',
    'login' => ''
];
$titulo = "Adicionar Novo Usuário";
$is_editing = false; // Flag para o formulário

// (2) Modo Edição
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $titulo = "Editar Usuário";
    $is_editing = true;
    
    try {
        // Busca sem o hash da senha
        $sql = "SELECT id, nome, login FROM usuarios WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
        } else {
            die("Usuário não encontrado.");
        }
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        die("Erro: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?></title>
    <link rel="stylesheet" href="../estilo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    
    <div id="topo">
        <h1>::SISCONT::</h1>
        <div class="header-fab-info">
            <span>Força Aérea Brasileira</span>
            <img src="../img/gladio_80px.webp" alt="Gládio Alado FAB">
        </div>
    </div>
    
    <div id="conteudo-interno">
        <div class="main-content-card">
    
            <h2><?= $titulo ?></h2>
            
            <form action="usuarios_acao.php" method="POST">
                <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label for="nome">Nome Completo:</label>
                        <input type="text" id="nome" name="nome" 
                               value="<?= htmlspecialchars($usuario['nome']) ?>" 
                               required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label for="login">Login de Acesso:</label>
                        <input type="text" id="login" name="login" 
                               value="<?= htmlspecialchars($usuario['login']) ?>" 
                               required>
                    </div>
                </div>

                <hr style="margin: 20px 0;">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="senha">Nova Senha:</label>
                        <input type="password" id="senha" name="senha" <?php if (!$is_editing) echo 'required'; ?>>
                        <?php if ($is_editing): ?>
                            <small>Deixe em branco para não alterar a senha atual.</small>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="senha_confirma">Confirmar Nova Senha:</label>
                        <input type="password" id="senha_confirma" name="senha_confirma" <?php if (!$is_editing) echo 'required'; ?>>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit">Salvar</button>
                    <a href="usuarios_index.php" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        
        </div> </div> <div id="rodape">
        <img src="../img/Dom_Pagl.jpg" alt="Emblema PAGL" class="footer-logo">
        <div class="footer-text">
            <strong>Prefeitura de Aeronáutica do Galeão</strong>
            &copy; <?= date('Y'); ?> SISCONT. Todos os direitos reservados. | Desenvolvido por: SO Hugo
        </div>
    </div>

</body>
</html>
