<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion libreria";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Obtener datos del libro con información del autor
    $sql = "SELECT libros.id, libros.titulo, libros.fecha_publicacion, libros.precio, libros.autor_id, autores.nombre AS nombre_autor, autores.apellido AS apellido_autor 
            FROM libros 
            LEFT JOIN autores ON libros.autor_id = autores.id 
            WHERE libros.id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $titulo = $_POST["titulo"];
    $fecha_publicacion = $_POST["fecha_publicacion"];
    $autor_id = $_POST["autor_id"];
    $precio = $_POST["precio"];

    $sql = "UPDATE libros SET titulo='$titulo', fecha_publicacion='$fecha_publicacion', autor_id='$autor_id', precio='$precio' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Libro actualizado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
        Título: <input type="text" name="titulo" value="<?php echo $row["titulo"]; ?>"><br><br>
        Fecha de Publicación: <input type="date" name="fecha_publicacion" value="<?php echo $row["fecha_publicacion"]; ?>"><br><br>
        Autor ID: <input type="text" name="autor_id" value="<?php echo $row["autor_id"]; ?>"><br><br>
        Precio: <input type="text" name="precio" value="<?php echo $row["precio"]; ?>"><br><br>
        <input type="submit" value="Actualizar Libro">
    </form>
    <br>
    <a href="list_libros.php">Volver a la Lista de Libros</a>
</body>
</html>

<?php
$conn->close();
?>
