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

// Obtener el término de búsqueda si existe
$searchTerm = "";
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}

// Modificar la consulta SQL para incluir el término de búsqueda
$sql = "SELECT libros.id, libros.titulo, libros.fecha_publicacion, libros.precio, autores.nombre AS nombre_autor, autores.apellido AS apellido_autor 
        FROM libros 
        INNER JOIN autores ON libros.autor_id = autores.id";

if (!empty($searchTerm)) {
    $sql .= " WHERE libros.titulo LIKE '%$searchTerm%' OR autores.nombre LIKE '%$searchTerm%' OR autores.apellido LIKE '%$searchTerm%'";
}

// Depuración: mostrar la consulta SQL generada
echo "Consulta SQL: $sql<br>";

// Ejecutar la consulta y manejar errores
$result = $conn->query($sql);
if (!$result) {
    echo "Error en la consulta: " . $conn->error;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Libros</title>
</head>
<body>
    <h1>Lista de Libros</h1>
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="search" placeholder="Buscar por título o autor" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <input type="submit" value="Buscar">
    </form>
    <br>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Fecha de Publicación</th>
            <th>Precio</th>
            <th>Autor</th>
            <th>Acciones</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["titulo"] . "</td>";
                echo "<td>" . $row["fecha_publicacion"] . "</td>";
                echo "<td>" . $row["precio"] . "</td>";
                echo "<td>" . $row["nombre_autor"] . " " . $row["apellido_autor"] . "</td>";
                echo "<td><a href='edit_libro.php?id=" . $row["id"] . "'>Editar</a> | <a href='delete_libro.php?id=" . $row["id"] . "'>Eliminar</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No hay libros</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="add_libro.php">Añadir Nuevo Libro</a>
</body>
</html>

<?php
$conn->close();
?>
