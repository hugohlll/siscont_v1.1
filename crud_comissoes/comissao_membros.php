<?php
// (1) Proteção
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

include "../conexao.php"; // Conexão

$idcom = (int)$_GET['id'];
if ($idcom <= 0) {
    die("ID da comissão é inválido.");
}

try {
    // (2) Query 1: Buscar dados da COMISSÃO
    $sql_info = "SELECT c.tipocom, ct.numerocont, ct.omcont, ct.anocont, e.nomeempresa
                 FROM comissoes c
                 JOIN contratos ct ON c.contratos_idcont = ct.idcont
                 JOIN empresas e ON ct.idempresa = e.idempresa
                 WHERE c.idcom = ?";
    $stmt_info = $mysqli->prepare($sql_info);
    $stmt_info->bind_param("i", $idcom);
    $stmt_info->execute();
    $result_info = $stmt_info->get_result();
    $comissao_info = $result_info->fetch_assoc();
    $stmt_info->close();

    if (!$comissao_info) {
        die("Comissão não encontrada.");
    }

    // (3) Query 2: Buscar MEMBROS ATUAIS
    $sql_membros = "SELECT m.nomemil, pg.nomepg, f.nomefuncao, mhc.idmilitar
                    FROM militares_has_comissoes mhc
                    JOIN militares m ON mhc.idmilitar = m.idmilitar
                    JOIN posto_grad pg ON m.idpg = pg.idpg
                    JOIN funcoes f ON mhc.idfuncao = f.idfuncao
                    WHERE mhc.idcom = ?
                    ORDER BY mhc.idfuncao"; 
    $stmt_membros = $mysqli->prepare($sql_membros);
    $stmt_membros->bind_param("i", $idcom);
    $stmt_membros->execute();
    $result_membros = $stmt_membros->get_result();
    $membros_atuais = $result_membros->fetch_all(MYSQLI_ASSOC);
    $stmt_membros->close();

    // (4) Query 3: Buscar TODOS os MILITARES
    $sql_todos_mil = "SELECT m.idmilitar, m.nomegr, pg.nomepg 
                      FROM militares m
                      JOIN posto_grad pg ON m.idpg = pg.idpg
                      ORDER BY m.nomegr";
    $result_todos_mil = $mysqli->query($sql_todos_mil);
    $todos_militares = $result_todos_mil->fetch_all(MYSQLI_ASSOC);

    // (5) Query 4: Buscar TODAS as FUNÇÕES
    $sql_todas_func = "SELECT idfuncao, nomefuncao FROM funcoes ORDER BY nomefuncao";
    $result_todas_func = $mysqli->query($sql_todas_func);
    $todas_funcoes = $result_todas_func->fetch_all(MYSQLI_ASSOC);

} catch (mysqli_sql_exception $e) {
    // *** A LINHA CORRIGIDA ESTÁ AQUI ***
    die("Erro ao carregar dados: " . $e->getMessage());
}

$titulo_pagina = sprintf(
    "Comissão de %s - Contrato %s/%s/%s (%s)",
    htmlspecialchars($comissao_info['tipocom']),
    htmlspecialchars($comissao_info['numerocont']),
    htmlspecialchars($comissao_info['omcont']),
    htmlspecialchars($comissao_info['anocont']),
    htmlspecialchars($comissao_info['nomeempresa'])
);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Membros da Comissão</title>
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
    
            <h2>Gerenciar Membros da Comissão</h2>
            <h3 style="color: #0056b3; font-weight: 500; margin-top: -15px;"><?= $titulo_pagina ?></h3>
            
            <p style="margin-bottom: 20px;">
                <a href="comissoes_index.php" class="btn-secondary-crud">Voltar para Comissões</a>
            </p>

            <form action="membros_acao.php" method="POST" class="form-row" style="align-items: flex-end; background-color: #f9f9f9; padding: 20px; border-radius: 8px;">
                <input type="hidden" name="acao" value="adicionar">
                <input type="hidden" name="idcom" value="<?= $idcom ?>">

                <div class="form-group" style="flex: 2;">
                    <label for="idmilitar">Militar:</label>
                    <select name="idmilitar" id="idmilitar" required>
                        <option value="">-- Selecione um Militar --</option>
                        <?php foreach ($todos_militares as $mil): ?>
                            <option value="<?= $mil['idmilitar'] ?>">
                                (<?= htmlspecialchars($mil['nomepg']) ?>) <?= htmlspecialchars($mil['nomegr']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="flex: 1;">
                    <label for="idfuncao">Função:</label>
                    <select name="idfuncao" id="idfuncao" required>
                        <option value="">-- Selecione uma Função --</option>
                        <?php foreach ($todas_funcoes as $func): ?>
                            <option value="<?= $func['idfuncao'] ?>">
                                <?= htmlspecialchars($func['nomefuncao']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="flex: 0;">
                    <button type="submit" style="padding: 12px 20px; border:none; border-radius: 4px; background-color: #27a750; color: white; cursor: pointer; font-weight: bold;">Adicionar</button>
                </div>
            </form>

            <h3 style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 30px;">Membros Atuais</h3>
            <table>
                <thead>
                    <tr>
                        <th>Posto/Grad</th>
                        <th>Nome</th>
                        <th>Função</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($membros_atuais) == 0): ?>
                        <tr><td colspan="4">Nenhum membro associado a esta comissão.</td></tr>
                    <?php endif; ?>

                    <?php foreach ($membros_atuais as $membro): ?>
                        <tr>
                            <td><?= htmlspecialchars($membro['nomepg']) ?></td>
                            <td><?= htmlspecialchars($membro['nomemil']) ?></td>
                            <td><?= htmlspecialchars($membro['nomefuncao']) ?></td>
                            <td>
                                <a href="membros_acao.php?acao=excluir&idcom=<?= $idcom ?>&idmilitar=<?= $membro['idmilitar'] ?>"
                                   class="action-delete-link"
                                   onclick="return confirm('Tem certeza que deseja remover este membro da comissão?');">
                                   Remover
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        
        </div> </div> <div id="rodape">
        &copy; <?= date('Y'); ?> SISCONT. Todos os direitos reservados. | Desenvolvido por: SO Hugo
    </div>

</body>
</html>
