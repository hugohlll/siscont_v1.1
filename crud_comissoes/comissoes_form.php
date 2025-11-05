<?php
// (1) Proteção
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

include "../conexao.php"; // Conexão

$comissao = [
    'idcom' => '', 'tipocom' => '', 'contratos_idcont' => '',
    'vigencia_ini' => '', 'vigencia_fim' => '', 'portaria_num' => '',
    'portaria_data' => '', 'bol_num' => '', 'bol_data' => '',
    'obs' => '', 'status' => 'vigente'
];
$titulo = "Adicionar Nova Comissão";

// Enumerações
$tipos_comissao = ['FISCALIZAÇÃO', 'RECEBIMENTO', 'FISCALIZAÇÃO OBRAS/SV ENGENHARIA', 'RECEBIMENTO EM DEFINITIVO'];
$status_comissao = ['vigente', 'finalizada', 'revogada'];

try {
    // Query 1: Buscar CONTRATOS
    $sql_contratos = "SELECT idcont, numerocont, omcont, anocont, nomeempresa 
                      FROM CONTRATOS_LANCADOS_VW 
                      ORDER BY nomeempresa, anocont DESC, numerocont DESC";
    $stmt_contratos = $mysqli->query($sql_contratos);
    $contratos = $stmt_contratos->fetch_all(MYSQLI_ASSOC);

    // Query 2: Modo Edição
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $titulo = "Editar Comissão";
        
        $sql = "SELECT * FROM comissoes WHERE idcom = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $comissao = $result->fetch_assoc();
        } else {
            die("Comissão não encontrada.");
        }
        $stmt->close();
    }
} catch (mysqli_sql_exception $e) {
    die("Erro: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?></title>
    <link rel="stylesheet" href="../estilo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    
    <div id="topo">
        <h1>::SISCONT::</h1>
        <div style="position: absolute; top: 22px; right: 30px; color: #ecf0f1;">
            Olá, <strong><?= htmlspecialchars($_SESSION['usuario_logado']); ?></strong>! 
            <a href="../logout.php" style="color: #fff; text-decoration: underline; margin-left: 15px;">(Sair)</a>
        </div>
    </div>
    
    <div id="conteudo-interno">
        <div class="main-content-card">
    
            <h2><?= $titulo ?></h2>
            
            <form action="comissoes_acao.php" method="POST">
                <input type="hidden" name="idcom" value="<?= $comissao['idcom'] ?>">
                
                <div class="form-group">
                    <label for="contratos_idcont">Contrato:</label>
                    <select id="contratos_idcont" name="contratos_idcont" required>
                        <option value="">-- Selecione um Contrato --</option>
                        <?php foreach ($contratos as $contrato): ?>
                            <option value="<?= $contrato['idcont'] ?>"
                                <?= ($contrato['idcont'] == $comissao['contratos_idcont']) ? 'selected' : '' ?>
                            >
                                <?= htmlspecialchars($contrato['nomeempresa']) ?> (<?= $contrato['numerocont'] ?>/<?= $contrato['omcont'] ?>/<?= $contrato['anocont'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="tipocom">Tipo de Comissão (Enum):</label>
                        <select id="tipocom" name="tipocom" required>
                            <?php foreach ($tipos_comissao as $tipo): ?>
                                <option value="<?= $tipo ?>" <?= ($comissao['tipocom'] == $tipo) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($tipo) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status (Enum):</label>
                        <select id="status" name="status" required>
                            <?php foreach ($status_comissao as $status): ?>
                                <option value="<?= $status ?>" <?= ($comissao['status'] == $status) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars(ucfirst($status)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="vigencia_ini">Vigência Início:</label>
                        <input type="date" id="vigencia_ini" name="vigencia_ini" 
                               value="<?= htmlspecialchars($comissao['vigencia_ini']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="vigencia_fim">Vigência Fim:</label>
                        <input type="date" id="vigencia_fim" name="vigencia_fim" 
                               value="<?= htmlspecialchars($comissao['vigencia_fim']) ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="portaria_num">Número Portaria:</label>
                        <input type="number" id="portaria_num" name="portaria_num" 
                               value="<?= htmlspecialchars($comissao['portaria_num']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="portaria_data">Data Portaria:</label>
                        <input type="date" id="portaria_data" name="portaria_data" 
                               value="<?= htmlspecialchars($comissao['portaria_data']) ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="bol_num">Número Boletim:</label>
                        <input type="number" id="bol_num" name="bol_num" 
                               value="<?= htmlspecialchars($comissao['bol_num']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="bol_data">Data Boletim:</label>
                        <input type="date" id="bol_data" name="bol_data" 
                               value="<?= htmlspecialchars($comissao['bol_data']) ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="obs">Observações:</label>
                    <textarea id="obs" name="obs" rows="3"><?= htmlspecialchars($comissao['obs']) ?></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit">Salvar Comissão</button>
                    <a href="comissoes_index.php" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        
        </div> </div> <div id="rodape">
        &copy; <?= date('Y'); ?> SISCONT. Todos os direitos reservados.
    </div>

</body>
</html>
