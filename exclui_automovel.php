<?php
$conexao = new mysqli("localhost", "root", "", "cadastro_automoveis", 3307);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

if (isset($_GET['codigo'])) {
    $codigo = intval($_GET['codigo']);

    $sql = "DELETE FROM automoveis WHERE codigo = $codigo";

    if ($conexao->query($sql) === TRUE) {
        header("Location: listaautomoveis.php?msg=excluido");
        exit;
    } else {
        echo "Erro ao excluir: " . $conexao->error;
    }
} else {
    echo "Código não informado.";
}

$conexao->close();
?>