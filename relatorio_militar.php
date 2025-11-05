<?php
// (1) Inicia a sessão e protege a página
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: index.php");
    exit;
}

include "conexao.php"; // Conexão

// (2) *** REMOVIDO ***
// A query que buscava todos os militares foi removida daqui.
// O carregamento agora é dinâmico (via AJAX).

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório - Histórico de Militar</title>
    <link rel="stylesheet" href="estilo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Garante que o Select2 ocupe 100% da largura */
        .select2-container {
            width: 100% !important;
        }
    </style>
</head>
<body>
    <div id="topo">
        <h1>::SISCONT::</h1>
        <div style="position: absolute; top: 22px; right: 30px; color: #ecf0f1;">
            Olá, <strong><?= htmlspecialchars($_SESSION['usuario_logado']); ?></strong>! 
            <a href="logout.php" style="color: #fff; text-decoration: underline; margin-left: 15px;">(Sair)</a>
        </div>
    </div>

    <div id="conteudo-interno">
        <div class="main-content-card">

            <h2>Histórico de Comissões por Militar</h2>
            <p style="margin-bottom: 20px;">
                <a href="dashboard.php" class="btn-secondary-crud">Voltar ao Painel</a>
            </p>
            
            <form method="POST" action="relatorio_militar_resultado.php">
                <p>Selecione um militar para ver todas as comissões em que esteve (vigentes e histórico).</p>
            
                <div class="form-group">
                    <label for="militar-search-id">Selecione o Militar:</label>
                    <select name="idmilitar" id="militar-search-id" required>
                        <option value="">Digite para buscar pelo nome...</option>
                        </select>
                </div>
                
                <div class="form-actions" style="border-top: none; padding-top: 0;">
                    <button type="submit" name="submit">GERAR RELATÓRIO</button>
                </div>
            </form>
        
        </div> </div> 

    <div id="rodape">
        &copy; <?= date('Y'); ?> SISCONT. Todos os direitos reservados. | Desenvolvido por: SO Hugo
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/pt-BR.js"></script>

    <script>
    // (8) *** NOVO *** Script de inicialização do Select2
    $(document).ready(function() {
        $('#militar-search-id').select2({
            placeholder: 'Digite o nome de guerra ou nome completo...',
            language: "pt-BR", // Tradução
            ajax: {
                url: 'buscar_militares_por_id.php', // A nova API que criamos
                dataType: 'json',
                delay: 250, 
                data: function (params) {
                    return {
                        term: params.term // Envia o ?term=...
                    };
                },
                processResults: function (data) {
                    // Retorna os dados no formato { id: ..., text: ... }
                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: 2 // Começa a buscar após 2 caracteres
        });
    });
    </script>
</body>
</html>
