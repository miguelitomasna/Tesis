<?php
// Incluir la conexión a la base de datos
include('../config/conexion.php');

// Establecer el encabezado para permitir CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$usuarios = []; // Variable para almacenar los usuarios registrados

// Verificar el tipo de solicitud HTTP
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Consulta SQL para obtener todos los usuarios
    $query = "SELECT id, nombre, apellidos, correo_electronico, telefono, rol FROM usuarios";
    
    // Preparar y ejecutar la consulta
    $stmt = $conexion->prepare($query);
    
    if ($stmt->execute()) {
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($usuarios);
    } else {
        echo json_encode(['message' => 'Error al obtener los usuarios', 'error' => $stmt->errorInfo()]);
    }
    
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos JSON del cliente
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Validar que todos los datos necesarios estén presentes
    if (isset($data['nombre'], $data['apellidos'], $data['email'], $data['telefono'], $data['rol'], $data['password'])) {
        $nombre = $data['nombre'];
        $apellidos = $data['apellidos'];
        $email = $data['email'];
        $telefono = $data['telefono'];
        $rol = $data['rol'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        // Verificar si el correo ya existe
        $queryCheckEmail = "SELECT COUNT(*) FROM usuarios WHERE correo_electronico = :email";
        $stmtCheckEmail = $conexion->prepare($queryCheckEmail);
        $stmtCheckEmail->execute([':email' => $email]);
        $emailCount = $stmtCheckEmail->fetchColumn();

        if ($emailCount > 0) {
            echo json_encode(['message' => 'El correo electrónico ingresado ya existe, ingrese otro.']);
            exit; // Detener la ejecución si el correo ya existe
        }

        // Consulta SQL para insertar el usuario
        $query = "INSERT INTO usuarios (nombre, apellidos, correo_electronico, telefono, rol, contraseña) 
                  VALUES (:nombre, :apellidos, :email, :telefono, :rol, :password)";
        
        $stmt = $conexion->prepare($query);
        
        // Ejecutar la consulta
        if ($stmt->execute([ 
            ':nombre' => $nombre,
            ':apellidos' => $apellidos,
            ':email' => $email,
            ':telefono' => $telefono,
            ':rol' => $rol,
            ':password' => $password
        ])) {
            echo json_encode(['message' => 'Usuario agregado correctamente']);
        } else {
            // Capturar errores y devolver más detalles
            $errorInfo = $stmt->errorInfo();
            echo json_encode([ 
                'message' => 'Error al agregar el usuario', 
                'error' => $errorInfo[2], 
                'sql' => $stmt->queryString
            ]);
        }
    } else {
        echo json_encode(['message' => 'Datos incompletos']);
    }
    
} else {
    echo json_encode(['message' => 'Método no válido']);
}
?>
