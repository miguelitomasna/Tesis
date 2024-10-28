<?php
// Incluir la conexión a la base de datos
include('../config/conexion.php');

// Establecer el encabezado para permitir CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Verificar el tipo de solicitud HTTP
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Obtener los datos JSON del cliente
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['id'])) {
        $id = $data['id'];
        
        // Consulta SQL para eliminar el usuario
        $query = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $conexion->prepare($query);
        
        // Ejecutar la consulta
        if ($stmt->execute([':id' => $id])) {
            echo json_encode(['message' => 'Usuario eliminado correctamente']);
        } else {
            echo json_encode(['message' => 'Error al eliminar el usuario', 'error' => $stmt->errorInfo()]);
        }
    } else {
        echo json_encode(['message' => 'ID del usuario no proporcionado']);
    }
    
} else {
    echo json_encode(['message' => 'Método no válido']);
}
?>
