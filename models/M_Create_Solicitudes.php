<?php
// Incluir archivo de conexión a la base de datos
include('../config/conexion.php');

// Consulta para obtener la cantidad de solicitudes
$query = "SELECT COUNT(*) as cantidad_solicitudes FROM problemas";
$stmt = $conexion->prepare($query);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

// Devolver la cantidad de solicitudes en formato JSON
echo json_encode(['cantidad_solicitudes' => $resultado['cantidad_solicitudes']]);
?>
