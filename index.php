<?php
// (Seu código PHP de sessão e verificação permanece o mesmo)
session_start();
include "conexao.php"; 
$erro_login = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $login_digitado = $_POST['login'];
    $senha_digitada = $_POST['senha'];

    $sql = "SELECT login, senha_hash FROM usuarios WHERE login = ? LIMIT 1";
    
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $login_digitado);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $usuario = $result->fetch_assoc();
        
        if (password_verify($senha_digitada, $usuario['senha_hash'])) {
            session_regenerate_id(true); 
            $_SESSION['usuario_logado'] = $usuario['login'];
            header("Location: dashboard.php");
            exit;
        } else {
            $erro_login = "Login ou senha inválidos!";
        }
    } else {
        $erro_login = "Login ou senha inválidos!";
    }
    
    $stmt->close();
    $mysqli->close();
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistema Controle Interno - Login</title>
        <link rel="stylesheet" type="text/css" href="estilo.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    
    <body>
        
        <div id="topo">
            <h1>::SISCONT::</h1>
            
            <div class="header-fab-info">
                <span>Força Aérea Brasileira</span>
                <img src="img/gladio_80px.webp" alt="Gládio Alado FAB">
            </div>
        </div>
                
        <div id="conteudo">
            
            <div class="login-card"> 
                
                <h2>Login do Sistema</h2>
                
                <form name="flogin" action="index.php" method="post">
                    
                    <?php if (!empty($erro_login)): ?>
                        <div class="login-erro"><?= htmlspecialchars($erro_login); ?></div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="login">Login:</label>
                        <input id="login" name="login" type="text" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input id="senha" name="senha" type="password" required>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div id="rodape">
            <img src="img/Dom_Pagl.png" alt="Emblema PAGL" class="footer-logo">
            <div class="footer-text">
                <strong>Prefeitura de Aeronáutica do Galeão</strong>
                &copy; <?= date('Y'); ?> SISCONT. Todos os direitos reservados. | Desenvolvido por: SO Hugo
            </div>
        </div>
        
    </body>
</html>
