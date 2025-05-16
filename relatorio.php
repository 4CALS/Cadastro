<?php
$mysqli = new mysqli("192.168.0.2", "4cals", "123@4Cals", "cadastro");

if ($mysqli->connect_error) {
    die("Erro na conexão: " . $mysqli->connect_error);
}

$resultado = $mysqli->query("SELECT nome, funcao, turma FROM registros ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Cadastros</title>
    <style>

    :root {
    --azul-intermedio: #89c4f4;
    --pastel-rosa: #FFD6E0;
    --pastel-azul: #C1E3FF;
    --pastel-verde: #D0F0C0;
    --pastel-lilas: #E2D1F9;
    --pastel-amarelo: #FFF9C4;
    --cinza-claro: #F8F9FA;
    --texto-escuro: #3A3A3A;
    --sombra: 0 4px 15px rgba(0, 0, 0, 0.1);
    --borda-arredondada: 12px;
}

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #F8F9FA;
            padding: 2rem;
            border-radius: 12px;
        }

        h1{
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 1rem;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color:var(--azul-intermedio);
            color: white;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            color:rgb(255, 255, 255);
            margin-bottom: 1rem;
            background: #89c4f4;
        }

        .voltar {
            margin-top: 1rem;
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color:var(--azul-intermedio);
            color: white;
            text-decoration: none;
            border-radius: 10px;
        }

        .voltar:hover {
            background-color:rgb(62, 166, 251);
        }
    </style>
</head>
<body>
    <h1>Relatório de Cadastros</h1>

    <table>
        <tr>
            <th>Nome</th>
            <th>Função</th>
            <th>Turma</th>
        </tr>
        <?php while ($row = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['nome']) ?></td>
                <td><?= htmlspecialchars($row['funcao']) ?></td>
                <td><?= htmlspecialchars($row['turma']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a class="voltar" href="index.html">⬅ Voltar</a>
</body>
</html>

<?php
$mysqli->close();
?>
