<?php
$servername = "localhost";
$username = "root";
$password = ""; // Asegúrate de que esto coincida con tu contraseña actual
$dbname = "gestion_libreria"; // Nombre de la base de datos sin espacios
$port = 3307; // Especifica el puerto

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];

    // Preparar la consulta SQL para insertar el autor
    $sql = "INSERT INTO autores (nombre, apellido) VALUES ('$nombre', '$apellido')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Autor añadido correctamente.";
    } else {
        echo "Error al añadir el autor: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Añadir Nuevo Autor</title>
</head>
<body>
    <h1>Añadir Nuevo Autor</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Nombre: <input type="text" name="nombre" required><br><br>
        Apellido: <input type="text" name="apellido" required><br><br>
        <input type="submit" value="Añadir Autor">
    </form>
    <br>
    <a href="list_autores.php">Lista de Autores</a>
</body>
</html>
