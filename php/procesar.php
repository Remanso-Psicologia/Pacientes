<?php
session_start(); // Iniciar sesión

// Establecer tiempo de expiración en minutos (por ejemplo, 15 minutos)
$timeout_duration = 15 * 60;  // 15 minutos en segundos

// Si la sesión ya ha expirado, redirigir al login
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    // Destruir la sesión
    session_unset();
    session_destroy();
    header("Location: ..\index.html");  // Redirigir al formulario de login
    exit();
}

// Actualizar el tiempo de la última actividad
$_SESSION['last_activity'] = time();

// Establecer la conexión con la base de datos
$servername = "localhost"; // Cambiar si el servidor de la base de datos está en otro lugar
$username = "formulario"; // Tu usuario de base de datos
$password_bd = "vy87uDyml_(t5k67"; // Tu contraseña de base de datos
$dbname = "consultorio"; // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password_bd, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir los datos del formulario HTML
$nombre = $_POST['nombre'];
$email = $_POST['email'];

// Preparar la consulta SQL para insertar los datos
$sql = "INSERT INTO usuarios (nombre, email) VALUES (?, ?)";

// Preparar la consulta
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $nombre, $email); // "ss" indica que ambos parámetros son cadenas

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "Registro exitoso.";
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>