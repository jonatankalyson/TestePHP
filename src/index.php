<?php
require_once 'C:/xampp/htdocs/TestePHP/config/verificar_conexao.php';

$conn = new mysqli($host, $user, $password, $database);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Inicializar o array $empresas para evitar erros de variável indefinida
$empresas = [];

// Obter todas as empresas do banco de dados
$result = $conn->query("SELECT id_empresa, nome FROM tbl_empresa");

// Verificar se há resultados e preencher o array $empresas
if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $empresas[] = $row;
        }
    } else {
        echo "Nenhuma empresa encontrada.";
    }
} else {
    echo "Erro na consulta SQL: " . $conn->error;
}

// Fechar a conexão
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Conta a Pagar</title>
</head>
<body>
    <h1>Adicionar Conta a Pagar</h1>
    <a href="cadastrar_empresa.php">Cadastrar Empresa</a><br><br>
    <form method="post">
        <label for="id_empresa">Empresa:</label>
        <select name="id_empresa" id="id_empresa" required>
            <option value="">Selecione uma empresa</option>
            <?php if (!empty($empresas)): ?>
                <?php foreach ($empresas as $empresa): ?>
                    <option value="<?= $empresa['id_empresa'] ?>"><?= htmlspecialchars($empresa['nome']) ?></option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">Nenhuma empresa disponível</option>
            <?php endif; ?>
        </select><br><br>

        <label for="data_pagar">Data a ser paga:</label>
        <input type="date" name="data_pagar" id="data_pagar" required><br><br>

        <label for="valor">Valor:</label>
        <input type="number" step="0.01" name="valor" id="valor" required><br><br>

        <button type="submit">Inserir</button>
    </form>
</body>
</html>
