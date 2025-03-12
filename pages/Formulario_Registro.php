<?php
session_start(); // Iniciar sesión

// Establecer tiempo de expiración en minutos (por ejemplo, 15 minutos)
$timeout_duration = 15 * 60;  // 15 minutos en segundos

// Verificar si la sesión ha expirado
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    // Destruir la sesión si ha expirado
    session_unset();
    session_destroy();
    header("Location: ..\index.html?error=Sesión_Expirada");  // Redirigir al formulario de login
    exit();
}

// Actualizar el tiempo de la última actividad
$_SESSION['last_activity'] = time();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    // Si no está autenticado, redirigir al login
    header("Location: ..\index.html?error=Sesion_Cerrada");
    exit();
}

// Si está autenticado, continuar con la página protegida
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro de Paciente</title>
	<link rel="stylesheet" href="../css/formulario.css">
</head>
<body>
    <div class="container">
        <h2>Formulario de Registro de Paciente</h2>
		
        <form action="\php\procesar.php" method="POST">
            <!-- Datos personales -->
			<h2 class="h2">Datos Del Paciente</h2>

            <div class="form-group">
                <label for="nombre">Nombre completo *</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>			
            <div class="form-row">
				<div class="form-group">
                    <label for="documento">No. de Documento *</label>
                    <input type="text" id="documento" name="documento" required>
                </div>				
				<div class="form-group">
					<label for="ocupacion">Ocupación *</label>
					<input type="text" id="ocupacion" name="ocupacion" required>
				</div>				
            </div>
            <div class="form-row">
				<div class="form-group">
					<label for="edad">Edad *</label>
					<input type="text" id="edad" name="edad" required>
				</div>
				<div class="form-group">
					<label for="fecha_nacimiento">Fecha de nacimiento *</label>
					<input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
				</div>
            </div>
			
            <div class="form-row">
				<div class="form-group">
                    <label for="genero">Género *</label>
                    <input type="radio" id="masculino" name="genero" value="masculino" required>Masculino</input><br>
					<input type="radio" id="femenino" name="genero" value="femenino" required>Femenino</input><br>
					<input type="radio" id="otro" name="genero" value="otro" required>Otro</input><br>
                </div>				
				<div class="form-group">
					<label for="estado_civil">Estado Civil *</label>
					<input type="radio" id="soltero" name="estado_civil" value="soltero" required>Soltero/a</input><br>					
					<input type="radio" id="casado" name="estado_civil" value="casado" required>Casado/a</input><br>
					<input type="radio" id="union_libre" name="estado_civil" value="union_libre" required>Union Libre</input><br>
					<input type="radio" id="separado" name="estado_civil" value="separado" required>Separado/a</input><br>
					<input type="radio" id="viudo" name="estado_civil" value="viudo" required>Viudo/a</input><br>
				</div>				
			</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="eps">EPS *</label>
                    <input type="eps" id="eps" name="eps" required>
                </div>
                <div class="form-group">
                    <label for="rh">RH *</label>
                    <input type="rh" id="rh" name="rh" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="celular">Celular *</label>
                    <input type="cel" id="celular" name="celular" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico *</label>
                    <input type="email" id="email" name="email" required>
                </div>
            </div>

            <div class="form-row">
				<div class="form-group">
					<label for="direccion">Ciudad de Residencia *</label>
					<input type="text" id="direccion" name="direccion" required>
				</div>
				<div class="form-group">
					<label for="direccion">Dirección de Residencia *</label>
					<input type="text" id="direccion" name="direccion" required>
				</div>
            </div>

            <!-- Antecedentes -->
			<h2 class="h2">Antecedentes</h2>
            <div class="form-group">
                <label for="motivo_consulta">Motivo de consulta:</label>
                <textarea id="motivo_consulta" name="motivo_consulta" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="antecedentes_psicologicos">Antecedentes psicológicos:</label>
                <textarea id="antecedentes_psicologicos" name="antecedentes_psicologicos" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="expectativas_proceso">Expectativas con el proceso:</label>
                <textarea id="expectativas_proceso" name="expectativas_proceso" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="enfermedades_diagnosticadas">Enfermedades diagnosticadas:</label>
                <textarea id="enfermedades_diagnosticadas" name="enfermedades_diagnosticadas" rows="4"></textarea>
            </div>

            <!-- Información médica -->
			<h2 class="h2">Contacto de Emergencia</h2>
            <div class="form-group">
                <label for="nombre_e">Nombre completo *</label>
				<input type="text" id="nombre_e" name="nombre_e" required>
            </div>
			<div class="form-group">
                <label for="celular_e">Celular *</label>
                <input type="text" id="celular_e" name="celular_e" required>
            </div>
            <div class="form-group">
                <label for="parentesco">Parentesco *</label>
                <input type="text" id="parentesco" name="parentesco" required>
            </div>			
			
            <button type="submit" class="btn">Registrar paciente</button>

        </form>
    </div>
</body>
</html>