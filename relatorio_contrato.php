<?php
// (1) Inicia a sessão e protege a página
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: index.php");
    exit;
}

include "conexao.php"; // Conexão

// A query para carregar todos os contratos foi removida
// O carregamento agora é dinâmico (via AJAX/Select2)
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório - Histórico de Comissões</title>
    <link rel="stylesheet" href="estilo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
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
                <h2 style="margin: 0; text-align: left;">Relatório de Comissões por Contrato</h2>
                <div style="color: #555; font-weight: 500;">
                    Olá, <strong><?= htmlspecialchars($_SESSION['usuario_logado']); ?></strong>! 
                    <a href="logout.php" style="color: #34495e; text-decoration: underline; margin-left: 15px;">(Sair)</a>
                </div>
            </div>

            <p style="margin-bottom: 20px;">
                <a href="dashboard.php" class="btn-secondary-crud">Voltar ao Painel</a>
            </p>
            
            <form method="POST" action="relatorio_contrato_resultado.php">
                <p>Selecione um contrato para ver o histórico de comissões vigentes, finalizadas e revogadas.</p>
                
                <div class="form-group">
                    <label for="contrato-search-id">Selecione o Contrato:</label>
                    <select name="idcont" id="contrato-search-id" required>
                        <option value="">Digite para buscar...</option>
                    </select>
                </div>
                
                <div class="form-actions" style="border-top: none; padding-top: 0;">
                    <button type="submit" name="submit">GERAR RELATÓRIO</button>
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
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/pt-BR.js"></script>

    <script>
    $(document).ready(function() {
        $('#contrato-search-id').select2({
            placeholder: 'Digite o nome da empresa, número ou ano do contrato...',
            language: "pt-BR", 
            ajax: {
                url: 'buscar_contratos_por_id.php', 
                dataType: 'json',
                delay: 250, 
                data: function (params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: 2 
        });
    });
    </script>
</body>
</html>
