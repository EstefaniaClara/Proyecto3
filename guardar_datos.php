<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datosHumedad";

// Obtener los datos enviados por POST
$city = $_POST['city'];
$humidity = $_POST['humidity'];

// Crear conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Preparar la consulta SQL para insertar los datos en la tabla
$sql = "INSERT INTO historial (`ciudad`, `humedad`) VALUES (?, ?)";

// Preparar la sentencia
$stmt = $conn->prepare($sql);

// Vincular los parámetros de la consulta con los valores
$stmt->bind_param("ss", $city, $humidity);

// Ejecutar la consulta
if ($stmt->execute()) {
    $response = "Datos guardados correctamente en la base de datos.";
} else {
    $response = "Error al guardar los datos en la base de datos: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$stmt->close();
$conn->close();

// Devolver la respuesta al cliente
echo $response;
?>
