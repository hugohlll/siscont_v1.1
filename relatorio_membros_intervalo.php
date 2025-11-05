<?php
// (1) Inicia a sessão e protege a página
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: index.php");
    exit;
}

include "conexao.php"; // Conexão
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório - Membros por Período</title>
    <link rel="stylesheet" href="estilo.css">
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

            <h2>Relatório de Membros Ativos por Período</h2>
            <p style="margin-bottom: 20px;">
                <a href="dashboard.php" class="btn-secondary-crud">Voltar ao Painel</a>
            </p>
        
            <form method="POST" action="relatorio_membros_resultado.php">
                <p>Mostra todos os militares que estavam em comissões ativas durante o intervalo de tempo selecionado.</p>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="data_inicio">Data Início do Filtro:</label>
                        <input type="date" id="data_inicio" name="data_inicio" required>
                    </div>
                    <div class="form-group">
                        <label for="data_fim">Data Fim do Filtro:</label>
                        <input type="date" id="data_fim" name="data_fim" required>
                    </div>
                </div>
                
                <div class="form-actions" style="border-top: none; padding-top: 0;">
                    <button type="submit" name="submit">GERAR RELATÓRIO</button>
                </div>
            </form>

        </div> </div> <div id="rodape">
        <img src="img/Dom_Pagl.png" alt="Emblema PAGL" class="footer-logo">
        <div class="footer-text">
            <strong>Prefeitura de Aeronáutica do Galeão</strong>
            &copy; <?= date('Y'); ?> SISCONT. Todos os direitos reservados. | Desenvolvido por: SO Hugo
        </div>
    </div>
    
</body>
</html>
