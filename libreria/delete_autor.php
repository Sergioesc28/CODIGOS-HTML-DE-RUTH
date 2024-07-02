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

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta SQL para eliminar el autor
    $sql = "DELETE FROM autores WHERE id = $id";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Autor eliminado correctamente.";
    } else {
        echo "Error al eliminar el autor: " . $conn->error;
    }
} else {
    echo "ID de autor no válido.";
}

$conn->close();
?>
