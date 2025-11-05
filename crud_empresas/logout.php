<?php
session_start(); // Inicia a sessão
session_unset(); // Remove todas as variáveis da sessão
session_destroy(); // Destrói a sessão

// Redireciona o usuário de volta para a página de login
header("Location: index.php");
exit;
?>
