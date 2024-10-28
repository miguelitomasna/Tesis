<?php
// conexion.php

// Definir los parámetros de conexión
$servidor = "localhost"; // Cambia esto si tu servidor es diferente
$usuario = "root"; // Tu usuario de la base de datos
$contraseña = ""; // Tu contraseña de la base de datos (deja vacío si no la tienes)
$base_de_datos = "db_fiscalipro"; // Nombre de la base de datos

// Crear la conexión
try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$base_de_datos", $usuario, $contraseña);
    // Establecer el modo de error de PDO
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
