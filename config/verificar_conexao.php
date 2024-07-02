<?php
include 'config.php';

// Conectar ao banco de dados
$conn = new mysqli($host, $user, $password, $database);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}else{
    echo"conexão sucesso";
}

// Inserir nova conta a pagar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_empresa = $_POST['id_empresa'];
    $data_pagar = $_POST['data_pagar'];
    $valor = $_POST['valor'];
    
    $stmt = $conn->prepare("INSERT INTO tbl_conta_pagar (id_empresa, data_pagar, valor, pago) VALUES (?, ?, ?, 0)");
    $stmt->bind_param("isd", $id_empresa, $data_pagar, $valor);
    
    if ($stmt->execute()) {
        echo "Conta a pagar adicionada com sucesso!";
    } else {
        echo "Erro ao adicionar conta: " . $stmt->error;
    }
    
    $stmt->close();
}

// Obter todas as empresas para o dropdown
$result = $conn->query("SELECT id_empresa, nome FROM tbl_empresa");
$empresas = [];
while ($row = $result->fetch_assoc()) {
    $empresas[] = $row;
}

$conn->close();
?>