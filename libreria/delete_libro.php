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

// Inicializar variables
$titulo = "";
$fecha_publicacion = "";
$precio = "";
$autor_id = "";
$id = "";

// Verificar si se recibió un ID válido por GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos del libro para prellenar el formulario
    $sql = "SELECT * FROM libros WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $titulo = $row['titulo'];
        $fecha_publicacion = $row['fecha_publicacion'];
        $precio = $row['precio'];
        $autor_id = $row['autor_id'];
    } else {
        echo "No se encontró el libro.";
        exit();
    }
} else {
    echo "ID de libro no válido.";
    exit();
}

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $titulo = $_POST['titulo'];
    $fecha_publicacion = $_POST['fecha_publicacion'];
    $precio = $_POST['precio'];
    $autor_id = $_POST['autor_id'];

    // Preparar la consulta SQL para actualizar el libro
    $sql = "UPDATE libros SET titulo='$titulo', fecha_publicacion='$fecha_publicacion', precio='$precio', autor_id='$autor_id' WHERE id=$id";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Libro actualizado correctamente.";
    } else {
        echo "Error al actualizar el libro: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Libro</title>
</head>
<body>
    <h1>Editar Libro</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>">
        Título: <input type="text" name="titulo" value="<?php echo $titulo; ?>" required><br><br>
        Fecha de Publicación: <input type="date" name="fecha_publicacion" value="<?php echo $fecha_publicacion; ?>" required><br><br>
        Precio: <input type="number" step="0.01" name="precio" value="<?php echo $precio; ?>" required><br><br>
        Autor:
        <select name="autor_id" required>
            <?php
            // Obtener la lista de autores para el menú desplegable
            $sql = "SELECT id, nombre, apellido FROM autores";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $selected = ($row['id'] == $autor_id) ? "selected" : "";
                    echo "<option value='" . $row['id'] . "' $selected>" . $row['nombre'] . " " . $row['apellido'] . "</option>";
                }
            } else {
                echo "<option value=''>No hay autores disponibles</option>";
            }
            ?>
        </select><br><br>
        <input type="submit" value="Actualizar Libro">
    </form>
    <br>
    <a href="list_libros.php">Lista de Libros</a>
</body>
</html>
