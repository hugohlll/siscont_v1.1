<?php
// (1) Inicia a sessão (para verificar se está logado ou não)
session_start();
$usuario_esta_logado = isset($_SESSION['usuario_logado']);

header("Content-type: text/html; charset=utf-8");
include "conexao.php";

// (2) Inicializa variáveis de resultado e dados dos formulários
$show_results_contrato = false;
$show_results_militar = false;
$contrato_data = [];
$militar_data = [];
$termo_busca_militar = "";
$active_tab = 'contrato'; // Aba padrão
$tipos_comissao = [];
$lista_contratos = [];
$erro_carregamento = ""; 

// (3) Carregamento de dados para os formulários
try {
    // Query para o <select> de tipos de comissão
    $query_tipos = 'SELECT DISTINCT tipocom FROM COMISSOES_INTEGRANTES';
    $result_tipos = $mysqli->query($query_tipos, MYSQLI_STORE_RESULT);
    if ($result_tipos) {
        while (list($tipocom) = $result_tipos->fetch_row()) {
            $tipos_comissao[] = $tipocom;
        }
    } else {
        $erro_carregamento .= "Erro ao carregar Tipos de Comissão: " . $mysqli->error . "<br>";
    }
    // (A query de contratos foi removida daqui, é carregada por AJAX)
} catch (mysqli_sql_exception $e) {
    die("Erro fatal de conexão: " . $e->getMessage());
}

// (4) Lógica de consulta (quando um formulário é enviado)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // LÓGICA PARA O FORMULÁRIO 1: CONSULTA POR CONTRATO
    if (isset($_POST['submit_contrato'])) {
        $tipo = $_POST['tipocom'];
        $contrato = $_POST['contrato'];
        $contrato_data = ['tipo' => $tipo, 'contrato' => $contrato, 'portaria' => 'N/D', 'boletim' => 'N/D', 'vigencia' => 'N/D', 'integrantes' => [], 'idcom' => null];
        try {
            $qidcom = "SELECT CI.id, C.status FROM COM_INTEG_AGRUP_1 as CI, comissoes as C WHERE CI.id=C.idcom AND C.status='vigente' AND CI.tipo=? AND CI.contrato=?;";
            $stmt0 = $mysqli->prepare($qidcom);
            $stmt0->bind_param("ss", $tipo, $contrato);
            $stmt0->execute();
            $result0 = $stmt0->get_result();
            $row0 = $result0->fetch_array(MYSQLI_ASSOC);
            $idcom = $row0['id'] ?? null;
            $contrato_data['idcom'] = $idcom;
            if ($idcom) {
                $qpb = "SELECT CONCAT(portaria_num,'/ACI, de ', DATE_FORMAT(portaria_data, '%d/%m/%Y')) portaria, CONCAT(bol_num,', de ', date_format(bol_data,'%d/%m/%Y')) boletim, DATE_FORMAT(vigencia_fim, '%d/%m/%Y') vigencia FROM comissoes WHERE idcom=?;";
                $stmt1 = $mysqli->prepare($qpb);
                $stmt1->bind_param("i", $idcom);
                $stmt1->execute();
                $result1 = $stmt1->get_result();
                $row1 = $result1->fetch_array(MYSQLI_ASSOC);
                if ($row1) { $contrato_data['portaria'] = $row1['portaria']; $contrato_data['boletim'] = $row1['boletim']; $contrato_data['vigencia'] = $row1['vigencia']; }
                $qint = "SELECT concat(nomepg, ' ', nomegr) militar, nomefuncao funcao FROM COMISSOES_INTEGRANTES WHERE idcom=? ORDER BY idcom, idfuncao;";
                $stmt2 = $mysqli->prepare($qint);
                $stmt2->bind_param("i", $idcom);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                $contrato_data['integrantes'] = $result2->fetch_all(MYSQLI_ASSOC);
            }
        } catch (mysqli_sql_exception $e) { die("Erro na consulta por Contrato: " . $e->getMessage()); }
        $show_results_contrato = true;
        $active_tab = 'contrato'; 
    }
    // LÓGICA PARA O FORMULÁRIO 2: CONSULTA POR MILITAR (VIGENTES)
    if (isset($_POST['submit_militar'])) {
        $nome_militar = $_POST['nome_militar'];
        $termo_busca_militar = $nome_militar;
        $search_term = "%" . $nome_militar . "%";
        try {
            $sql = "SELECT nome_militar, nomegr, funcao, contrato, inicio_comissao, fim_comissao FROM VW_MEMBROS_COMISSOES_DETALHES WHERE (nome_militar LIKE ? OR nomegr LIKE ?) AND status_comissao = 'vigente' ORDER BY nome_militar, inicio_comissao DESC";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", $search_term, $search_term);
            $stmt->execute();
            $result = $stmt->get_result();
            $militar_data = $result->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) { die("Erro na consulta por Militar: " . $e->getMessage()); }
        $show_results_militar = true;
        $active_tab = 'militar';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONSULTAS PÚBLICAS</title>
    <link rel="stylesheet" href="estilo.css">
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <style>
        /* (Todo o CSS de Abas e Resultados) */
        .tab-nav { display: flex; border-bottom: 2px solid #ccc; margin-bottom: 25px; }
        .tab-button {
            padding: 12px 20px; cursor: pointer; background-color: #f0f0f0;
            border: 1px solid #ccc; border-bottom: none; margin-right: 5px;
            border-radius: 5px 5px 0 0; font-size: 1em; font-weight: 500;
            color: #555; position: relative; top: 2px;
        }
        .tab-button.active {
            background-color: #fff; border-bottom: 2px solid #fff;
            color: #27a750; font-weight: bold;
        }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        #secao-resultados-wrapper {
            width: 100%; max-width: 1200px; background: #ffffff;
            padding: 30px; border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            box-sizing: border-box; margin: 30px auto 0 auto;
        }
        #secao-resultados-wrapper h2 {
            text-align: left; margin-top: 0; margin-bottom: 20px;
            padding-bottom: 15px; border-bottom: 1px solid #eee; color: #333;
        }
        .results-table {
            width: 100%; border-collapse: collapse;
        }
        .results-table th, 
        .results-table td {
            border: 1px solid #ddd; padding: 12px 15px;
            text-align: left; font-size: 0.95em;
        }
        .results-table th { background-color: #f2f2f2; }
        .results-row {
            display: flex;
            flex-wrap: wrap; 
            gap: 30px;       
        }
        .results-col-left {
            flex: 1; 
            min-width: 350px; 
        }
        .results-col-right {
            flex: 1.5; 
            min-width: 350px; 
        }
        .info-table {
            width: 100%; margin-bottom: 0;
            border: 1px solid #eee; border-collapse: collapse;
        }
        .info-table th, .info-table td {
            padding: 12px 15px; font-size: 0.95em;
            border: 1px solid #eee;
        }
        .info-table th { background-color: #f2f2f2; text-align: left; }
        .info-table td { background-color: #fff; }
        .info-table tr td:first-child {
            font-weight: bold; background-color: #f9f9f9;
            width: 120px;
        }
        .results-col-right h3,
        .results-col-left h3 {
             font-size: 1.2em;
             margin-top: 0;
             margin-bottom: 10px;
             color: #333;
        }
        .results-col-right .results-table {
            margin-top: 0;
        }
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
                <h2 style="margin: 0; text-align: left;">Consultas Públicas</h2>
                <?php if ($usuario_esta_logado): ?>
                <div style="color: #555; font-weight: 500;">
                    Olá, <strong><?= htmlspecialchars($_SESSION['usuario_logado']); ?></strong>! 
                    <a href="logout.php" style="color: #34495e; text-decoration: underline; margin-left: 15px;">(Sair)</a>
                </div>
                <?php endif; ?>
            </div>
            
            <?php if ($usuario_esta_logado): ?>
                <p style="margin-bottom: 20px;">
                    <a href="dashboard.php" class="btn-secondary-crud">Voltar ao Painel</a>
                </p>
            <?php else: ?>
                <p style="margin-bottom: 20px;">
                    <a href="index.php" class="btn-secondary-crud">Acessar Sistema (Login)</a>
                </p>
            <?php endif; ?>

            <?php if (!empty($erro_carregamento)): ?>
                <div class="error-box">
                    <strong>Erro ao carregar dados:</strong><br>
                    <?= $erro_carregamento ?>
                </div>
            <?php endif; ?>

            <div class="tab-nav">
                <button class="tab-button <?php if ($active_tab == 'contrato') echo 'active'; ?>" onclick="openTab(event, 'tabContrato')">
                    Comissão por Contrato
                </button>
                <button class="tab-button <?php if ($active_tab == 'militar') echo 'active'; ?>" onclick="openTab(event, 'tabMilitar')">
                    Militar em Comissão
                </button>
            </div>
            
            <div id="tabContrato" class="tab-content <?php if ($active_tab == 'contrato') echo 'active'; ?>">
                <form method="POST" action="consulta_comissao.php">
                    <h3 style="margin-top:0;">Comissão por Contrato (Apenas Vigentes)</h3>
                    <div class="form-group">
                        <label for="tipocom">Tipo comissão</label>
                        <select name="tipocom" id="tipocom">
                            <?php foreach ($tipos_comissao as $tipocom): ?>
                                <option value="<?= htmlspecialchars($tipocom) ?>"><?= htmlspecialchars($tipocom) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="contrato-search">Contrato:</label>
                        <select name="contrato" id="contrato-search" class="form-control" required>
                            <option value="">Digite para buscar...</option>
                        </select>
                    </div>
                    <div class="form-actions" style="border-top: none; padding-top: 0;">
                        <button type="submit" name="submit_contrato">CONSULTAR</button>
                    </div>
                </form>
            </div> 

            <div id="tabMilitar" class="tab-content <?php if ($active_tab == 'militar') echo 'active'; ?>">
                <form method="POST" action="consulta_comissao.php">
                    <h3 style="margin-top:0;">Militar em comissão (Apenas Vigentes)</h3>
                    <div class="form-group">
                        <label for="nome_militar">Nome de Guerra ou parte do Nome Completo:</label>
                        <input type="text" id="nome_militar" name="nome_militar" required>
                    </div>
                    <div class="form-actions" style="border-top: none; padding-top: 0;">
                        <button type="submit" name="submit_militar">Consultar Militar</button>
                    </div>
                </form>
            </div>
        </div> 
        
        <?php if ($show_results_contrato || $show_results_militar): ?>
            <div id="secao-resultados-wrapper">
                
                <?php if ($show_results_contrato): ?>
                    <h2>Resultado da Consulta por Contrato</h2>
                    <?php if ($contrato_data['idcom']): ?>
                        <div class="results-row">
                            <div class="results-col-left">
                                <h3 style="margin-top:0;">Informações da Comissão</h3>
                                <table class="info-table">
                                    <tr><th colspan="2">COMISSÃO DE <?php echo "<strong>" . htmlspecialchars($contrato_data['tipo']) . "</strong>"; ?></th></tr>
                                    <tr><th colspan="2">CONTRATO <?php echo "<strong>" . htmlspecialchars($contrato_data['contrato']) . "</strong>"; ?></th></tr>
                                    <tr><td>Portaria</td><td><?php echo htmlspecialchars($contrato_data['portaria']); ?></td></tr>
                                    <tr><td>Boletim</td><td><?php echo htmlspecialchars($contrato_data['boletim']); ?></td></tr>
                                    <tr><td>Vigência</td><td><?php echo htmlspecialchars($contrato_data['vigencia']); ?></td></tr>
                                </table>
                            </div>
                            <div class="results-col-right">
                                <h3 style="margin-top:0;">Integrantes</h3>
                                <?php if (count($contrato_data['integrantes']) > 0): ?>
                                    <table class="results-table">
                                        <thead><tr><th>MILITAR</th><th>FUNÇÃO</th></tr></thead>
                                        <tbody>
                                            <?php foreach ($contrato_data['integrantes'] as $integrante): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($integrante['militar']); ?></td>
                                                    <td><?php echo htmlspecialchars($integrante['funcao']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p style="text-align: center; padding-top: 20px;">Nenhum integrante encontrado para esta comissão.</p>
                                <?php endif; ?>
                            </div>
                        </div> 
                    <?php else: ?>
                        <p style="text-align: center;">Nenhuma comissão vigente encontrada com os filtros selecionados.</p>
                    <?php endif; ?>
                <?php endif; ?>
                
                <?php if ($show_results_militar): ?>
                    <h2>Resultado da Consulta por Militar (Vigentes)</h2>
                    <p>Exibindo comissões vigentes para: "<strong><?= htmlspecialchars($termo_busca_militar); ?></strong>"</p>
                    <table class="results-table">
                        <thead><tr><th>Militar</th><th>Função</th><th>Contrato</th><th>Início Comissão</th><th>Fim Comissão</th></tr></thead>
                        <tbody>
                            <?php if (count($militar_data) == 0): ?>
                                <tr><td colspan="5">Nenhuma comissão vigente encontrada para este militar.</td></tr>
                            <?php endif; ?>
                            <?php foreach ($militar_data as $comissao): ?>
                            <tr>
                                <td><?= htmlspecialchars($comissao['nome_militar']) ?></td>
                                <td><?= htmlspecialchars($comissao['funcao']) ?></td>
                                <td><?= htmlspecialchars($comissao['contrato']) ?></td>
                                <td><?= date('d/m/Y', strtotime($comissao['inicio_comissao'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($comissao['fim_comissao'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div> 
        <?php endif; ?>
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
    function openTab(evt, tabName) {
        var i, tabcontent, tabbuttons;
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].classList.remove("active");
        }
        tabbuttons = document.getElementsByClassName("tab-button");
        for (i = 0; i < tabbuttons.length; i++) {
            tabbuttons[i].classList.remove("active");
        }
        document.getElementById(tabName).classList.add("active");
        evt.currentTarget.classList.add("active");
    }

    $(document).ready(function() {
        $('#contrato-search').select2({
            placeholder: 'Digite o nome da empresa, número ou ano do contrato...',
            language: "pt-BR", 
            ajax: {
                url: 'buscar_contratos.php', 
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
