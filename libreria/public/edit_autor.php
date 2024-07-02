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

    // Obtener datos del autor
    $sql = "SELECT * FROM autores WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];

    $sql = "UPDATE autores SET nombre='$nombre', apellido='$apellido', fecha_nacimiento='$fecha_nacimiento' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Autor actualizado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Autor</title>
</head>
<body>
    <h1>Editar Autor</h1>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
        Nombre: <input type="text" name="nombre" value="<?php echo $row["nombre"]; ?>"><br><br>
        Apellido: <input type="text" name="apellido" value="<?php echo $row["apellido"]; ?>"><br><br>
        Fecha de Nacimiento: <input type="date" name="fecha_nacimiento" value="<?php echo $row["fecha_nacimiento"]; ?>"><br><br>
        <input type="submit" value="Actualizar Autor">
    </form>
    <br>
    <a href="list_autores.php">Volver a la Lista de Autores</a>
</body>
</html>

<?php
$conn->close();
?>
