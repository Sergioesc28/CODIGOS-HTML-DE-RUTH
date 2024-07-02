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

    // Obtener los datos del autor para prellenar el formulario
    $sql = "SELECT * FROM autores WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre = $row['nombre'];
        $apellido = $row['apellido'];

        // Verificar si se envió el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];

            // Preparar la consulta SQL para actualizar el autor
            $sql = "UPDATE autores SET nombre='$nombre', apellido='$apellido' WHERE id=$id";

            // Ejecutar la consulta
            if ($conn->query($sql) === TRUE) {
                echo "Autor actualizado correctamente.";
            } else {
                echo "Error al actualizar el autor: " . $conn->error;
            }
        }
    } else {
        echo "No se encontró el autor.";
    }
} else {
    echo "ID de autor no válido.";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Autor</title>
</head>
<body>
    <h1>Editar Autor</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>">
        Nombre: <input type="text" name="nombre" value="<?php echo $nombre; ?>" required><br><br>
        Apellido
