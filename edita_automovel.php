<?php
$conexao = new mysqli("localhost", "root", "", "cadastro_automoveis", 3307);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

if (!isset($_GET['codigo'])) {
    die("Código do automóvel não informado.");
}

$codigo = intval($_GET['codigo']);
$msg = "";

if (isset($_POST['atualizar'])) {
    $nome = $conexao->real_escape_string($_POST['nome']);
    $placa = $conexao->real_escape_string($_POST['placa']);
    $chassi = $conexao->real_escape_string($_POST['chassi']);
    $montadora = intval($_POST['montadora']);

    $sql_check = "SELECT * FROM automoveis 
                  WHERE (placa='$placa' OR chassi='$chassi') AND codigo<>$codigo";
    $result_check = $conexao->query($sql_check);

    if ($result_check->num_rows > 0) {
        $msg = "Erro: Placa ou Chassi já cadastrado em outro automóvel!";
    } else {
        $sql_update = "UPDATE automoveis 
                       SET nome='$nome', placa='$placa', chassi='$chassi', montadora=$montadora 
                       WHERE codigo=$codigo";

        if ($conexao->query($sql_update) === TRUE) {
            header("Location: listaautomoveis.php?msg=atualizado");
            exit;
        } else {
            $msg = "Erro ao atualizar: " . $conexao->error;
        }
    }
}

$sql = "SELECT * FROM automoveis WHERE codigo=$codigo";
$result = $conexao->query($sql);

if ($result->num_rows == 0) {
    die("Automóvel não encontrado.");
}

$row = $result->fetch_assoc();

$sql_montadoras = "SELECT * FROM montadoras";
$result_montadoras = $conexao->query($sql_montadoras);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Automóvel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Editar Automóvel</h1>

        <div class="card shadow-lg p-4">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do Carro</label>
                    <input type="text" name="nome" id="nome" class="form-control" required value="<?php echo htmlspecialchars($row['nome']); ?>">
                </div>

                <div class="mb-3">
                    <label for="placa" class="form-label">Placa</label>
                    <input type="text" name="placa" id="placa" class="form-control" required value="<?php echo htmlspecialchars($row['placa']); ?>">
                </div>

                <div class="mb-3">
                    <label for="chassi" class="form-label">Chassi</label>
                    <input type="text" name="chassi" id="chassi" class="form-control" required value="<?php echo htmlspecialchars($row['chassi']); ?>">
                </div>

                <div class="mb-3">
                    <label for="montadora" class="form-label">Montadora</label>
                    <select name="montadora" id="montadora" class="form-select" required>
                        <?php
                        if ($result_montadoras->num_rows > 0) {
                            while ($m = $result_montadoras->fetch_assoc()) {
                                $selected = ($m['codigo'] == $row['montadora']) ? 'selected' : '';
                                echo "<option value='" . $m['codigo'] . "' $selected>" . $m['nome'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" name="atualizar" class="btn btn-primary">Atualizar</button>
                    <a href="listaautomoveis.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>