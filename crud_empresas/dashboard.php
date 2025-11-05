<?php
// (1) Inicia a sessão
session_start();

// (2) O "Segurança": Verifica se a sessão 'usuario_logado' NÃO existe
if (!isset($_SESSION['usuario_logado'])) {
    
    // (3) Se não existe, expulsa o usuário de volta para o "portão" (login)
    header("Location: index.php");
    exit;
}

// (4) Se o script chegou até aqui, o usuário ESTÁ logado.
// Mostra o nome do usuário e um link de Logout.
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>::SISCONT:: Painel Principal</title>
    <link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
    <div id="topo">
        <h1>::SISCONT::</h1>
        <div style="position: absolute; top: 10px; right: 10px; color: black;">
            Olá, <?= htmlspecialchars($_SESSION['usuario_logado']); ?>! 
            <a href="logout.php">(Sair)</a>
        </div>
    </div>
    
    <div id="conteudo">
        <h2>Painel de Controle</h2>
        
        <h3>Consultas</h3>
        <ul>
            <li><a href="consulta_comissao.php">Consultar Comissões por Contrato</a></li>
        </ul>

        <h3>Gerenciamento (CRUD)</h3>
        <ul>
            <li><a href="crud_empresas/empresas_index.php">Gerenciar Empresas</a></li>
            </ul>
    </div>
</body>
</html>
