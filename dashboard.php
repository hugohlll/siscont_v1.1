<?php
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>::SISCONT:: Painel Principal</title>
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
    
    <div id="conteudo-interno">
        <div class="main-content-card">
        
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <h2 style="margin: 0; text-align: left;">Painel de Controle</h2>
                <div style="color: #555; font-weight: 500;">
                    Olá, <strong><?= htmlspecialchars($_SESSION['usuario_logado']); ?></strong>! 
                    <a href="logout.php" style="color: #34495e; text-decoration: underline; margin-left: 15px;">(Sair)</a>
                </div>
            </div>
            
            <div class="dashboard-menu">
            
                <div class="dashboard-section">
                    <h3>Consultas e Relatórios</h3>
                    <ul>
                        <li><a href="consulta_comissao.php">Consulta Rápida de Comissão</a></li>
                        <li><a href="relatorio_contrato.php">Relatório por Contrato</a></li> 
                        <li><a href="relatorio_membros_intervalo.php">Relatório de Membros por Período</a></li>
                        <li><a href="relatorio_militar.php">Histórico por Militar</a></li>
                    </ul>
                </div>
                
                <div class="dashboard-section">
                    <h3>Gerenciamento Principal</h3>
                    <ul>
                        <li><a href="crud_comissoes/comissoes_index.php">Gerenciar Comissões</a></li>
                        <li><a href="crud_contratos/contratos_index.php">Gerenciar Contratos</a></li>
                        <li><a href="crud_militares/militares_index.php">Gerenciar Militares</a></li>
                    </ul>
                </div>

                <div class="dashboard-section">
                    <h3>Gerenciamento (Catálogos)</h3>
                    <ul>
                        <li><a href="crud_empresas/empresas_index.php">Gerenciar Empresas</a></li>
                        <li><a href="crud_posto_grad/posto_grad_index.php">Gerenciar Postos/Graduações</a></li>
                        <li><a href="crud_funcoes/funcoes_index.php">Gerenciar Funções</a></li>
                    </ul>
                </div>
                
                <div class="dashboard-section">
                <h3>Administração</h3>
                <ul>
                    <li><a href="crud_usuarios/usuarios_index.php">Gerenciar Usuários</a></li>
                </ul>
            </div>
                    
                
            </div> </div> </div> <div id="rodape">
        <img src="img/Dom_Pagl.png" alt="Emblema PAGL" class="footer-logo">
        <div class="footer-text">
            <strong>Prefeitura de Aeronáutica do Galeão</strong>
            &copy; <?= date('Y'); ?> SISCONT. Todos os direitos reservados. | Desenvolvido por: SO Hugo
        </div>
    </div>
    
</body>
</html>
