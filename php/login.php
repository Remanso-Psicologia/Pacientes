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
$username = "succes"; // Tu usuario de base de datos
$password_bd = "h6EjsYN(rNOhxKjN"; // Tu contraseña de base de datos
$dbname = "consultorio"; // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password_bd, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir los datos del formulario HTML
$user = $_POST['username'];
$pass = $_POST['password'];

// Consulta SQL con parámetro preparado
$sql = "SELECT * FROM credenciales WHERE id_usuario = ?";

// Preparar la consulta
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Error al preparar la consulta: ' . $conn->error);
}

// Vincular el parámetro (el nombre de usuario es una cadena, por lo que usamos "s")
$stmt->bind_param("s", $user);

// Ejecutar la consulta
$stmt->execute();

// Obtener el resultado
$result = $stmt->get_result();

// Verificar si el usuario existe
if ($result->num_rows > 0) {
    // Si el usuario existe, verificar la contraseña (asegúrate de que la contraseña esté correctamente hasheada en la base de datos)
    $row = $result->fetch_assoc();
    
    // Usar password_verify para verificar el hash de la contraseña
    if (password_verify($pass, $row['contrasena_hash'])) {
		session_regenerate_id(true); // Esto genera un nuevo ID de sesión
		$_SESSION['usuario_id'] = $row['id'];  // Puedes almacenar cualquier información relevante en la sesión
        header("Location: \pages\Formulario_Registro.php");  // Redirige a Formulario_Registro.php
        exit();
    } else {
        header("Location: ..\index.html?error=Contraseña_Incorrecta");
        exit();
    }
} else {
        header("Location: ..\index.html?error=Usuario_no_Encontrado");
        exit();
}
// Cerrar la conexión
$stmt->close();
$conn->close();
?>