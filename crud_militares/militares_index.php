<?php
// (1) Inicia a sessão e protege a página
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

include "../conexao.php"; 

try {
    $sql = "SELECT m.idmilitar, m.nomemil, m.nomegr, pg.nomepg 
            FROM militares m
            JOIN posto_grad pg ON m.idpg = pg.idpg
            ORDER BY m.nomemil";
            
    $stmt = $mysqli->query($sql);
    $militares = $stmt->fetch_all(MYSQLI_ASSOC);

} catch (mysqli_sql_exception $e) {
    die("Erro ao consultar militares: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Militares</title>
    <link rel="stylesheet" href="../estilo.css"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    
    <div id="topo">
        <h1>::SISCONT::</h1>
        <div class="header-fab-info">
            <span>Força Aérea Brasileira</span>
            <img src="../img/gladio_80px.webp" alt="Gládio Alado FAB">
        </div>
    </div>
    
    <div id="conteudo-interno">
        <div class="main-content-card">
    
            <h2>Gerenciamento de Militares</h2>
            
            <p style="margin-bottom: 20px;">
                <a href="militares_form.php" class="btn-primary-crud">Adicionar Novo Militar</a>
                <a href="../dashboard.php" class="btn-secondary-crud">Voltar ao Painel</a>
            </p>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Posto/Grad</th>
                        <th>Nome Completo</th>
                        <th>Nome de Guerra</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($militares as $militar): ?>
                    <tr>
                        <td><?= $militar['idmilitar'] ?></td>
                        <td><?= htmlspecialchars($militar['nomepg']) ?></td>
                        <td><?= htmlspecialchars($militar['nomemil']) ?></td>
                        <td><?= htmlspecialchars($militar['nomegr']) ?></td>
                        <td>
                            <a href="militares_form.php?id=<?= $militar['idmilitar'] ?>">Editar</a>
                            |
                            <a href="militares_acao.php?acao=excluir&id=<?= $militar['idmilitar'] ?>" 
                               class="action-delete-link"
                               onclick="return confirm('Tem certeza que deseja excluir? Este militar pode estar em uma comissão.');">
                               Excluir
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        
        </div> </div> <div id="rodape">
        <img src="../img/Dom_Pagl.png" alt="Emblema PAGL" class="footer-logo">
        <div class="footer-text">
            <strong>Prefeitura de Aeronáutica do Galeão</strong>
            &copy; <?= date('Y'); ?> SISCONT. Todos os direitos reservados. | Desenvolvido por: SO Hugo
        </div>
    </div>

</body>
</html>
