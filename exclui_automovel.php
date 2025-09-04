<?php
$conexao = new mysqli("localhost", "root", "", "cadastro_automoveis", 3307);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

if (isset($_GET['codigo'])) {
    $codigo = intval($_GET['codigo']);

    $check = $conexao->query("SELECT * FROM automoveis WHERE codigo = $codigo");
    if ($check->num_rows === 0) {
        header("Location: listaautomoveis.php?msg=naoencontrado");
        exit;
    }

    $sql = "DELETE FROM automoveis WHERE codigo = $codigo";

    if ($conexao->query($sql) === TRUE) {
        header("Location: listaautomoveis.php?msg=excluido");
        exit;
    } else {
        header("Location: listaautomoveis.php?msg=erro");
        exit;
    }
} else {
    header("Location: listaautomoveis.php?msg=codnaoinformado");
    exit;
}

$conexao->close();
?>