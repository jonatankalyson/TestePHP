<?php
require_once 'C:/xampp/htdocs/TestePHP/config/verificar_conexao.php';

$conn = new mysqli($host, $user, $password, $database);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Inserir nova empresa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_empresa = $_POST['nome_empresa'];

    // Verificar se o nome da empresa não está vazio
    if (!empty($nome_empresa)) {
        $stmt = $conn->prepare("INSERT INTO tbl_empresa (nome) VALUES (?)");
        $stmt->bind_param("s", $nome_empresa);

        if ($stmt->execute()) {
            echo "Empresa adicionada com sucesso!";
        } else {
            echo "Erro ao adicionar empresa: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "O nome da empresa é obrigatório.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Empresa</title>
</head>
<body>
    <h1>Cadastrar Empresa</h1>
    <form method="post">
        <label for="nome_empresa">Nome da Empresa:</label>
        <input type="text" name="nome_empresa" id="nome_empresa" required><br><br>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
