<?php
$conexao = new mysqli("localhost", "root", "", "cadastro_automoveis", 3307);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $conexao->real_escape_string($_POST['nome']);
    $placa = $conexao->real_escape_string($_POST['placa']);
    $chassi = $conexao->real_escape_string($_POST['chassi']);
    $montadora = intval($_POST['montadora']);

    $sql_insert = "INSERT INTO automoveis (nome, placa, chassi, montadora)
                    VALUES ('$nome', '$placa', '$chassi', $montadora)";

    if ($conexao->query($sql_insert) === TRUE) {
        $msg = "Automóvel cadastrado com sucesso!";
    } else {
        if ($conexao->errno == 1062) {
            $msg = "Erro: Placa ou Chassi já cadastrado1";
        } else {
            $msg = "Erro: " . $conexao->error;
        }
    }
}

$sql = "SELECT * FROM montadoras";
$result = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Automóveis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Cadastro de Automóveis</h1>

        <!-- Mensagem de sucesso ou erro -->
        <?php if ($msg): ?>
            <div class="alert <?= strpos($msg, 'Erro') !== false ? 'alert-danger' : 'alert-success' ?> text-center">
                <?= $msg ?>
            </div>
        <?php endif; ?>

        <form action="index.php" method="POST" class="mt-3 card shadow p-4">
            <div class="mb-3">
                <label class="form-label">Nome do carro</label>
                <input type="text" name="nome" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Placa do carro</label>
                <input type="text" name="placa" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Chassi do carro</label>
                <input type="text" name="chassi" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Montadora</label>
                <select name="montadora" class="form-select" required>
                    <option value="">Selecione</option>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <option value="<?= $row['codigo'] ?>"><?= $row['nome'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
        </form>

        <div class="text-center mt-3">
            <a href="listaautomoveis.php" class="btn btn-outline-secondary">Ver Lista de Automóveis</a>
        </div>
    </div>
</body>

</html>