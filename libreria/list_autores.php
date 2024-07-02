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

// Ejecutar consulta para obtener la lista de autores
$sql = "SELECT * FROM autores";
$result = $conn->query($sql);

// Verificar si la consulta fue exitosa
if ($result === FALSE) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Autores</title>
</head>
<body>
    <h1>Lista de Autores</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Acciones</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["apellido"] . "</td>";
                echo "<td><a href='edit_autor.php?id=" . $row["id"] . "'>Editar</a> | <a href='delete_autor.php?id=" . $row["id"] . "'>Eliminar</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No hay autores</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="add_autor.php">Añadir Nuevo Autor</a>
</body>
</html>

<?php
$conn->close();
?>
