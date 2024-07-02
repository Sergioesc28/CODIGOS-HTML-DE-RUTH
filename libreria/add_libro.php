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

// Variables para almacenar los datos del formulario
$titulo = "";
$fecha_publicacion = "";
$precio = "";
$autor_id = "";

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario y realizar las validaciones necesarias

    // Ejemplo básico de obtención de datos POST
    $titulo = $_POST['titulo'];
    $fecha_publicacion = $_POST['fecha_publicacion'];
    $precio = $_POST['precio'];
    $autor_id = $_POST['autor_id'];

    // Preparar la consulta SQL para insertar el libro
    $sql = "INSERT INTO libros (titulo, fecha_publicacion, precio, autor_id) VALUES ('$titulo', '$fecha_publicacion', $precio, $autor_id)";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Libro añadido correctamente.";
    } else {
        echo "Error al añadir el libro: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Añadir Nuevo Libro</title>
</head>
<body>
    <h1>Añadir Nuevo Libro</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Título: <input type="text" name="titulo" value="<?php echo $titulo; ?>"><br><br>
        Fecha de Publicación: <input type="date" name="fecha_publicacion" value="<?php echo $fecha_publicacion; ?>"><br><br>
        Precio: <input type="number" step="0.01" name="precio" value="<?php echo $precio; ?>"><br><br>
        Autor ID: <input type="number" name="autor_id" value="<?php echo $autor_id; ?>"><br><br>
        <input type="submit" value="Añadir Libro">
    </form>
</body>
</html>
