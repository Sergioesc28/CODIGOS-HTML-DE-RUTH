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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];

    $sql = "INSERT INTO autores (nombre, apellido, fecha_nacimiento) VALUES ('$nombre', '$apellido', '$fecha_nacimiento')";

    if ($conn->query($sql) === TRUE) {
        echo "Nuevo autor creado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Añadir Nuevo Autor</title>
</head>
<body>
    <h1>Añadir Nuevo Autor</h1>
    <form method="post" action="">
        Nombre: <input type="text" name="nombre"><br><br>
        Apellido: <input type="text" name="apellido"><br><br>
        Fecha de Nacimiento: <input type="date" name="fecha_nacimiento"><br><br>
        <input type="submit" value="Añadir Autor">
    </form>
    <br>
    <a href="list_autores.php">Volver a la Lista de Autores</a>
</body>
</html>

<?php
$conn->close();
?>
