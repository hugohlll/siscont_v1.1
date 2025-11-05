<?php
// (1) Proteção
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

include "../conexao.php"; // Conexão

$contrato = [
    'idcont' => '', 'idempresa' => '', 'numerocont' => '',
    'omcont' => '', 'anocont' => date('Y'), 'tipocont' => '',
    'vltotal' => '', 'objeto' => '', 'NUP' => '',
    'vigencia_ini' => '', 'vigencia_fim' => '', 'obs' => ''
];
$titulo = "Adicionar Novo Contrato";

try {
    // Query 1: Buscar empresas
    $stmt_empresas = $mysqli->query("SELECT idempresa, nomeempresa FROM empresas ORDER BY nomeempresa");
    $empresas = $stmt_empresas->fetch_all(MYSQLI_ASSOC);

    // Query 2: Modo Edição
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $titulo = "Editar Contrato";
        
        $sql = "SELECT * FROM contratos WHERE idcont = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $contrato = $result->fetch_assoc();
        } else {
            die("Contrato não encontrado.");
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
            
            <form action="contratos_acao.php" method="POST">
                <input type="hidden" name="idcont" value="<?= $contrato['idcont'] ?>">
                
                <div class="form-group">
                    <label for="idempresa">Empresa:</label>
                    <select id="idempresa" name="idempresa" required>
                        <option value="">-- Selecione uma Empresa --</option>
                        <?php foreach ($empresas as $empresa): ?>
                            <option value="<?= $empresa['idempresa'] ?>"
                                <?= ($empresa['idempresa'] == $contrato['idempresa']) ? 'selected' : '' ?>
                            >
                                <?= htmlspecialchars($empresa['nomeempresa']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="numerocont">Número Contrato:</label>
                        <input type="number" id="numerocont" name="numerocont" 
                               value="<?= htmlspecialchars($contrato['numerocont']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="omcont">OM Contratante (Enum):</label>
                        <select id="omcont" name="omcont">
                            <option value="">-- N/A --</option>
                            <option value="GAPGL" <?= ($contrato['omcont'] == 'GAPGL') ? 'selected' : '' ?>>GAPGL</option>
                            <option value="GAPGL-PAGL" <?= ($contrato['omcont'] == 'GAPGL-PAGL') ? 'selected' : '' ?>>GAPGL-PAGL</option>
                            <option value="GAPRJ" <?= ($contrato['omcont'] == 'GAPRJ') ? 'selected' : '' ?>>GAPRJ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="anocont">Ano:</label>
                        <input type="number" id="anocont" name="anocont" 
                               value="<?= htmlspecialchars($contrato['anocont']) ?>" 
                               min="1990" max="2099" step="1">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tipocont">Tipo (Enum):</label>
                        <select id="tipocont" name="tipocont">
                            <option value="">-- N/A --</option>
                            <option value="receita" <?= ($contrato['tipocont'] == 'receita') ? 'selected' : '' ?>>Receita</option>
                            <option value="despesa" <?= ($contrato['tipocont'] == 'despesa') ? 'selected' : '' ?>>Despesa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="vltotal">Valor Total (R$):</label>
                        <input type="number" id="vltotal" name="vltotal" 
                               value="<?= htmlspecialchars($contrato['vltotal']) ?>" 
                               step="0.01" min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label for="NUP">NUP:</label>
                    <input type="text" id="NUP" name="NUP" 
                           value="<?= htmlspecialchars($contrato['NUP']) ?>">
                </div>

                <div class="form-group">
                    <label for="objeto">Objeto do Contrato:</label>
                    <textarea id="objeto" name="objeto" rows="3"><?= htmlspecialchars($contrato['objeto']) ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="vigencia_ini">Vigência Início:</label>
                        <input type="date" id="vigencia_ini" name="vigencia_ini" 
                               value="<?= htmlspecialchars($contrato['vigencia_ini']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="vigencia_fim">Vigência Fim:</label>
                        <input type="date" id="vigencia_fim" name="vigencia_fim" 
                               value="<?= htmlspecialchars($contrato['vigencia_fim']) ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="obs">Observações:</label>
                    <textarea id="obs" name="obs" rows="3"><?= htmlspecialchars($contrato['obs']) ?></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit">Salvar Contrato</button>
                    <a href="contratos_index.php" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        
        </div> </div> <div id="rodape">
        &copy; <?= date('Y'); ?> SISCONT. Todos os direitos reservados.
    </div>

</body>
</html>
