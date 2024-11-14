<?php
// Incluir archivo de conexión a la base de datos
include('../config/conexion.php');

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $destinatario = $_POST['destinatario'];
    $tipo_problema = $_POST['tipo_problema'];
    $problema_descrito = $_POST['problema_descrito'];
    $correo_destinatario = $_POST['correo_destinatario'];

    // Verificar si se ha subido una imagen
    $imagen_adjunto = null;
    if (isset($_FILES['imagen_adjunto']) && $_FILES['imagen_adjunto']['error'] === UPLOAD_ERR_OK) {
        // Obtener el contenido de la imagen en formato binario
        $imagen_adjunto = file_get_contents($_FILES['imagen_adjunto']['tmp_name']);
    }

    // Preparar la consulta para insertar los datos
    $query = "INSERT INTO problemas (nombre_usuario, destinatario, tipo_problema, problema_descrito, correo_destinatario, imagen_adjunto)
              VALUES (:nombre_usuario, :destinatario, :tipo_problema, :problema_descrito, :correo_destinatario, :imagen_adjunto)";
    
    // Preparar la sentencia
    $stmt = $conexion->prepare($query);

    // Asociar los parámetros
    $stmt->bindParam(':nombre_usuario', $nombre_usuario);
    $stmt->bindParam(':destinatario', $destinatario);
    $stmt->bindParam(':tipo_problema', $tipo_problema);
    $stmt->bindParam(':problema_descrito', $problema_descrito);
    $stmt->bindParam(':correo_destinatario', $correo_destinatario);
    $stmt->bindParam(':imagen_adjunto', $imagen_adjunto, PDO::PARAM_LOB);  // Para manejar archivos binarios

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "El problema ha sido registrado correctamente.";
    } else {
        echo "Hubo un error al registrar el problema.";
    }
}
?>
