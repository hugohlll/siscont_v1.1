<?php
// (1) Proteção
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

include "../conexao.php"; 

try {
    // (2) Busca todos os usuários, EXCETO o hash da senha
    $sql = "SELECT id, login, nome FROM usuarios ORDER BY nome";
    $stmt = $mysqli->query($sql);
    $usuarios = $stmt->fetch_all(MYSQLI_ASSOC);

} catch (mysqli_sql_exception $e) {
    die("Erro ao consultar usuários: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Usuários</title>
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
    
            <h2>Gerenciamento de Usuários (Admin)</h2>
            
            <p style="margin-bottom: 20px;">
                <a href="usuarios_form.php" class="btn-primary-crud">Adicionar Novo Usuário</a>
                <a href="../dashboard.php" class="btn-secondary-crud">Voltar ao Painel</a>
            </p>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Login</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= $usuario['id'] ?></td>
                        <td><?= htmlspecialchars($usuario['nome']) ?></td>
                        <td><?= htmlspecialchars($usuario['login']) ?></td>
                        <td>
                            <a href="usuarios_form.php?id=<?= $usuario['id'] ?>">Editar</a>
                            
                            <?php if ($_SESSION['usuario_logado'] != $usuario['login']): ?>
                                |
                                <a href="usuarios_acao.php?acao=excluir&id=<?= $usuario['id'] ?>" 
                                   class="action-delete-link"
                                   onclick="return confirm('Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.');">
                                   Excluir
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        
        </div> </div> <div id="rodape">
        <img src="../img/Dom_Pagl.png" alt="Emblema PAGL" class="footer-logo">
        <div class="footer-text">
            <strong>Prefeitura de Aeronáutica do Galeão</strong>
            &copy; <?= date('Y'); ?> SISCONT. Todos os direitos reservados. | Desenvolvido por: SO Hugo
        </div>
    </div>

</body>
</html>
