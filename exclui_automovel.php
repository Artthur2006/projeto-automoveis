<?php
$conexao = new mysqli("localhost", "root", "", "cadastro_automoveis", 3307);

if ($conexão->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

if (isset($_GET['codigo'])) {
    $codigo = intval($_GET['codigo']);

    $sql = "DELETE FROM automoveis WHERE codigo = $codigo";
    if ($conexao->query($sql) === TRUE) {
        echo "Automóvel excluído com sucesso!";
    } else {
        echo "Error: " . $conexao->error;
    }
}

echo "<br><a href= 'lista_automoveis.php'>Voltar</a>";
?>