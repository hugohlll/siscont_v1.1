<?php
include "conexao.php"; // Inclui sua conexão mysqli

// Defina o login e a senha do seu primeiro admin
$login = "admin";
$senha_pura = "Claudi@ACI"; // Mude isso

// (1) Cria o HASH seguro da senha
$hash_da_senha = password_hash($senha_pura, PASSWORD_DEFAULT);

// (2) Insere o usuário no banco com a senha "hasheada"
$sql = "INSERT INTO usuarios (login, senha_hash, nome) VALUES (?, ?, ?)";

$stmt = $mysqli->prepare($sql);
$nome = "Administrador";
$stmt->bind_param("sss", $login, $hash_da_senha, $nome);

if ($stmt->execute()) {
    echo "Usuário '$login' criado com sucesso!";
} else {
    echo "Erro ao criar usuário: " . $stmt->error;
}

$stmt->close();
$mysqli->close();

// (3) DEPOIS DE RODAR, DELETE ESTE ARQUIVO DO SERVIDOR!
?>
