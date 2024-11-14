<?php
// Incluir la conexión a la base de datos
include('../config/conexion.php');

// Establecer el encabezado para permitir CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Verificar el tipo de solicitud HTTP
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $criterio = isset($_GET['criterio']) ? "%" . $_GET['criterio'] . "%" : "%";

    // Consulta SQL para buscar usuarios por nombre, apellidos, correo o teléfono
    $query = "SELECT id, nombre, apellidos, correo_electronico, telefono, rol 
              FROM usuarios 
              WHERE nombre LIKE :criterio 
                 OR apellidos LIKE :criterio 
                 OR correo_electronico LIKE :criterio 
                 OR telefono LIKE :criterio";
    
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':criterio', $criterio, PDO::PARAM_STR);
    
    if ($stmt->execute()) {
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($usuarios);
    } else {
        echo json_encode(['message' => 'Error al obtener los usuarios', 'error' => $stmt->errorInfo()]);
    }
} else {
    echo json_encode(['message' => 'Método no válido']);
}
?>
