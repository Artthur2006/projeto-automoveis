<?php
$conexao = new mysqli("localhost", "root", "", "cadastro_automoveis", 3307);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

$busca = "";
if (isset($_GET['busca'])) {
    $busca = $_GET['busca'];
}

$sql = "SELECT a.codigo, a.nome AS carro, a.placa, a.chassi, m.nome AS montadora FROM automoveis a
INNER JOIN montadoras m ON a.montadora = m.codigo";

if (!empty($busca)) {
    $busca_segura = $conexao->real_escape_string($busca);
    $sql .= " WHERE 
        a.nome LIKE '%$busca_segura%' OR
        a.placa LIKE '%$busca_segura%' OR
        a.chassi LIKE '%$busca_segura%' OR
        m.nome LIKE '%$busca_segura%'";
}

$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Automóveis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Lista de Automóveis</h1>

        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success text-center">
                <?= $_GET['msg'] == 'excluido' ? 'Automóvel excluído com sucesso!' : 'Automóvel atualizado com sucesso!' ?>
            </div>
        <?php endif; ?>

        <div class="card shadow-lg p-4 mb-4">
            <form method="GET" action="listaautomoveis.php" class="d-flex">
                <input type="text" name="busca" class="form-control me-2" placeholder="Buscar por qualquer campo" value="<?= htmlspecialchars($busca) ?>">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
        </div>

        <div class="card shadow-lg p-4">
            <table class="table table-bordered table-striped mb-0 text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Placa</th>
                        <th>Chassi</th>
                        <th>Montadora</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado->num_rows > 0): ?>
                        <?php while ($row = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['codigo'] ?></td>
                                <td><?= $row['carro'] ?></td>
                                <td><?= $row['placa'] ?></td>
                                <td><?= $row['chassi'] ?></td>
                                <td><?= $row['montadora'] ?></td>
                                <td class="text-center">
                                    <a href="edita_automovel.php?codigo=<?= $row['codigo'] ?>" class="btn btn-warning btn-sm me-2">Editar</a>
                                    <a href="exclui_automovel.php?codigo=<?= $row['codigo'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este automóvel?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Nenhum automóvel encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-3">
            <a href="index.php" class="btn btn-success">Cadastrar Novo Automóvel</a>
        </div>
    </div>
</body>

</html>