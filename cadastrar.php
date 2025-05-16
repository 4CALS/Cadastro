<?php
$mysqli = new mysqli("192.168.0.2", "4cals", "123@4Cals", "cadastro");

if ($mysqli->connect_error) {
    die("Erro na conexão: " . $mysqli->connect_error);
}

$nome = trim($_POST['nome'] ?? '');
$funcao = $_POST['funcao'] ?? '';
$turma = $_POST['turma'] ?? '';

// Ajusta a regra para duplicar turma quando for funcionário ou convidado
if (in_array($funcao, ['funcionario', 'convidado'])) {
    $turma = $funcao;
}

// Verifica se o nome já está cadastrado (sem espaços)
$verifica = $mysqli->prepare("SELECT COUNT(*) FROM registros WHERE TRIM(nome) = ?");
$verifica->bind_param("s", $nome);
$verifica->execute();
$verifica->bind_result($existe);
$verifica->fetch();
$verifica->close();

if ($existe > 0) {
    echo "duplicado";
    exit;
}

// Faz o cadastro
$stmt = $mysqli->prepare("INSERT INTO registros (nome, funcao, turma) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nome, $funcao, $turma);
$stmt->execute();
echo "sucesso";
?>
