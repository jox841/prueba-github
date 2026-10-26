<?php
// Configuración de la conexión a la base de datos usando las variables del entorno
$host = getenv('DB_HOST') ?: 'db';
$dbname = getenv('DB_NAME');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

$version_mariadb = "No se pudo conectar a la base de datos.";

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    // Consulta para obtener la versión del servidor MariaDB
    $stmt = $pdo->query("SELECT VERSION()");
    $version_mariadb = $stmt->fetchColumn();
} catch (PDOException $e) {
    $version_mariadb = "Error de conexión: " . $e->getMessage();
}

// Hora del servidor generada con PHP
$hora_servidor = date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica Docker - Cliente y Servidor</title>
    <style>
        body { font-family: sans-serif; margin: 40px; background-color: #f4f4f9; color: #333; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 20px; }
        h2 { color: #0066cc; margin-top: 0; }
        .destacado { font-size: 1.2rem; font-weight: bold; color: #d9534f; }
    </style>
</head>
<body>

    <h1>P1.5 — Control de Tiempo y Base de Datos</h1>

    <div class="card">
        <h2>Hora del Servidor (Procesado en Servidor - PHP)</h2>
        <p>Esta hora la calcula el contenedor de Docker:</p>
        <p class="destacado"><?php echo $hora_servidor; ?></p>
    </div>

    <div class="card">
        <h2>Hora del Navegador (Procesado en Cliente - JavaScript)</h2>
        <p>Esta hora la calcula tu propia máquina de escritorio:</p>
        <p class="destacado" id="hora-cliente">Cargando...</p>
    </div>

    <div class="card">
        <h2>Información de la Base de Datos</h2>
        <p>Versión actual de MariaDB obtenida mediante PDO:</p>
        <p class="destacado" style="color: #5cb85c;"><?php echo htmlspecialchars($version_mariadb); ?></p>
    </div>

    <script>
        // Función en JavaScript para obtener y formatear la hora del sistema cliente
        function mostrarHoraCliente() {
            const ahora = new Date();
            const opciones = { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            document.getElementById('hora-cliente').textContent = ahora.toLocaleString('es-ES', opciones).replace(',', '');
        }
        // Ejecutar inmediatamente al cargar la página
        mostrarHoraCliente();
        // Actualizar cada segundo para dinamismo en el cliente
        setInterval(mostrarHoraCliente, 1000);
    </script>
</body>
</html>
