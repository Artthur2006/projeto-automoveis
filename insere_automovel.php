<?php
$conexao = new mysqli("localhost", "root", "", "cadastro_automoveis", 3307);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

$nome = $_POST['nome'];
$placa = $_POST['placa'];
$chassi = $_POST['chassi'];
$montadora = $_POST['montadora'];

$sql = "INSERT INTO automoveis (nome, placa, chassi, montadora)
        VALUES ('$nome', '$placa', '$chassi', '$montadora')";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-lg p-4 text-center">
            <?php
            if ($conexao->query($sql) === TRUE) {
                echo "<h3 class='text-success mb-3'>Automóvel cadastrado com sucesso!</h3>";
            } else {
                echo "<h3 class='text-danger mb-3'>Erro: " . $conexao->error . "</h3>";
            }
            ?>
            <a href="index.php" class="btn btn-primary mt-3">Cadastrar Novo</a>
            <a href="listaautomoveis.php" class="btn btn-outline-secondary mt-3">Ver Lista de Automóveis</a>
        </div>
    </div>
</body>

</html>

<?php
$conexao->close();
?>