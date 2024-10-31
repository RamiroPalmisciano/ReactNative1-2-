<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Conectar a la base de datos
$host = "localhost";
$db_name = "users_db";
$username = "root";
$password = "";  // En XAMPP, usualmente es vacío

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener datos del cuerpo de la solicitud (email y password)
$data = json_decode(file_get_contents("php://input"));

if (isset($data->email) && isset($data->password)) {
    $email = $conn->real_escape_string($data->email);
    $password = md5($data->password);

    // Verificar usuario en la base de datos
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo json_encode(["message" => "Login exitoso", "status" => true]);
    } else {
        echo json_encode(["message" => "Email o contraseña incorrectos", "status" => false]);
    }
} else {
    echo json_encode(["message" => "Datos incompletos", "status" => false]);
}

$conn->close();
?>
