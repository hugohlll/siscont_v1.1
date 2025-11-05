<?php
// (1) Inicia a sessão para poder acessá-la
session_start(); 

// (2) Remove todas as variáveis da sessão (ex: $_SESSION['usuario_logado'])
session_unset(); 

// (3) Destrói completamente a sessão no servidor
session_destroy(); 

// (4) Redireciona o usuário de volta para a página de login
header("Location: index.php");
exit;
?>
