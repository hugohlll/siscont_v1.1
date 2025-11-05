<?php
// (1) Inicia a sessão e protege
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

include "../conexao.php"; // Conexão

$militar = [
    'idmilitar' => '',
    'idpg' => '',
    'nomemil' => '',
    'nomegr' => ''
];
$titulo = "Adicionar Novo Militar";

try {
    // Query 1: Buscar Postos/Graduações
    $stmt_postos = $mysqli->query("SELECT idpg, nomepg FROM posto_grad ORDER BY idpg");
    $postos = $stmt_postos->fetch_all(MYSQLI_ASSOC);

    // Query 2: Modo Edição
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $titulo = "Editar Militar";
        
        $sql = "SELECT * FROM militares WHERE idmilitar = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $militar = $result->fetch_assoc();
        } else {
            die("Militar não encontrado.");
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
            
            <form action="militares_acao.php" method="POST">
                <input type="hidden" name="idmilitar" value="<?= $militar['idmilitar'] ?>">
                
                <div class="form-group">
                    <label for="nomemil">Nome Completo:</label>
                    <input type="text" id="nomemil" name="nomemil" 
                           value="<?= htmlspecialchars($militar['nomemil']) ?>" 
                           required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nomegr">Nome de Guerra:</label>
                        <input type="text" id="nomegr" name="nomegr" 
                               value="<?= htmlspecialchars($militar['nomegr']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="idpg">Posto/Graduação:</label>
                        <select id="idpg" name="idpg" required>
                            <option value="">-- Selecione --</option>
                            <?php foreach ($postos as $posto): ?>
                                <option value="<?= $posto['idpg'] ?>"
                                    <?php if ($posto['idpg'] == $militar['idpg']) echo 'selected'; ?>
                                >
                                    <?= htmlspecialchars($posto['nomepg']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit">Salvar</button>
                    <a href="militares_index.php" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        
        </div> </div> <div id="rodape">
        &copy; <?= date('Y'); ?> SISCONT. Todos os direitos reservados.
    </div>

</body>
</html>
