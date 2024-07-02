<?php
// Obtener el ID del libro a editar desde el parámetro GET
if (!isset($_GET['id'])) {
    die("ID de libro no válido.");
}

$id = $_GET['id'];

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_libreria";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener los datos actuales del libro
$sql = "SELECT * FROM libros WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("Libro no encontrado.");
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $fecha_publicacion = $_POST['fecha_publicacion'];
    $precio = $_POST['precio'];
    $autor_id = $_POST['autor_id'];

    // Actualizar los datos del libro en la base de datos
    $update_sql = "UPDATE libros SET titulo = '$titulo', fecha_publicacion = '$fecha_publicacion', precio = '$precio', autor_id = $autor_id WHERE id = $id";

    if ($conn->query($update_sql) === TRUE) {
        echo "Libro actualizado correctamente.";
    } else {
        echo "Error al actualizar el libro: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Libro</title>
</head>
<body>
    <h1>Editar Libro</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=$id"); ?>">
        Título: <input type="text" name="titulo" value="<?php echo htmlspecialchars($row['titulo']); ?>"><br>
        Fecha de Publicación: <input type="date" name="fecha_publicacion" value="<?php echo htmlspecialchars($row['fecha_publicacion']); ?>"><br>
        Precio: <input type="number" name="precio" value="<?php echo htmlspecialchars($row['precio']); ?>"><br>
        
        <!-- Seleccionar autor -->
        <?php
        // Consulta para obtener los autores
        $autores_sql = "SELECT id, nombre, apellido FROM autores";
        $autores_result = $conn->query($autores_sql);
        
        if ($autores_result->num_rows > 0) {
            echo "Autor: <select name='autor_id'>";
            while ($autor = $autores_result->fetch_assoc()) {
                $selected = ($autor['id'] == $row['autor_id']) ? "selected" : "";
                echo "<option value='{$autor['id']}' $selected>{$autor['nombre']} {$autor['apellido']}</option>";
            }
            echo "</select><br>";
        } else {
            echo "No hay autores registrados.";
        }
        ?>

        <input type="submit" value="Guardar Cambios">
    </form>
</body>
</html>

<?php
$conn->close();
?>
