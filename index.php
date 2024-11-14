<?php
// Incluir el archivo de conexión
include('../fiscalipro/config/conexion.php'); // Asegúrate de que la ruta sea correcta

// Verificamos si la conexión se estableció correctamente
if (!$conexion) {
    die("Error: No se pudo establecer la conexión a la base de datos.");
}

$error_message = ''; // Variable para guardar los mensajes de error

// Verificamos si el formulario fue enviado (método POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Comprobamos si los campos no están vacíos
    if (isset($_POST['email-username']) && isset($_POST['password'])) {
        $email_username = $_POST['email-username'];
        $password = $_POST['password'];

        // Validamos que los campos no estén vacíos
        if (empty($email_username) || empty($password)) {
            $error_message = "Por favor, ingresa todos los campos.";
        } else {
            // Preparamos la consulta para buscar al usuario por correo electrónico o nombre de usuario
            $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo_electronico = :email_username OR nombre = :email_username");
            $stmt->bindParam(':email_username', $email_username);
            
            // Ejecutamos la consulta
            $stmt->execute();

            // Verificamos si el usuario existe
            if ($stmt->rowCount() > 0) {
                // Obtenemos los datos del usuario
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verificamos la contraseña
                if (password_verify($password, $usuario['contraseña'])) {
                    // El login fue exitoso, redirigimos al usuario
                    session_start();
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['nombre'] = $usuario['nombre'];
                    $_SESSION['apellidos'] = isset($usuario['apellidos']) ? $usuario['apellidos'] : ''; // Asignar apellidos si existen
                    $_SESSION['correo_electronico'] = $usuario['correo_electronico'];
                    $_SESSION['telefono'] = isset($usuario['telefono']) ? $usuario['telefono'] : ''; // Asignar teléfono si existe
                    $_SESSION['rol'] = $usuario['rol']; // Almacenar el rol en la sesión

                    // Redirigimos a la página de inicio o dashboard
                    header("Location: Views/dashboard.php");
                    exit;
                } else {
                    $error_message = "Contraseña incorrecta.";
                }
            } else {
                $error_message = "El usuario no existe.";
            }
        }
    } else {
        $error_message = "Por favor, ingresa todos los campos.";
    }
}
?>

<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Login - Fiscalia de Huánuco</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/icons/unicons/icon_fiscalia.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="assets/js/config.js"></script>
    <!-- Incluye Bootstrap JS (si no está incluido ya) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  </head>

  <style>
     /* Fondo con degradado azul serio y profesional con animación */
     body {
      background: linear-gradient(
        45deg,
        #102a43, /* Azul muy oscuro */
        #243b55, /* Azul oscuro medio */
        #3a506b, /* Azul serio intermedio */
        #5c677d, /* Azul grisáceo oscuro */
        #243b55, /* Azul oscuro medio */
        #102a43  /* Azul muy oscuro */
      );
      background-size: 300% 300%;
      animation: gradientAnimation 18s ease-in-out infinite;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    /* Animación del gradiente */
    @keyframes gradientAnimation {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* Estilo para los textos, si deseas aplicarlos de manera global */
    .text-white {
      color: #ffffff;
    }

    /* Estilo para el contenido en el centro */
    .content-container {
      background: rgba(0, 0, 0, 0.5); /* Fondo ligeramente oscuro para mejor contraste */
      padding: 20px;
      border-radius: 8px;
    }

    /* Ajustes para los mensajes de alerta */
    .alert-message {
      color: #566a7f; /* Color azul serio para los mensajes de error */
    }
  </style>
  <body>
    <!-- Content -->
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo centrado -->
              <div class="app-brand d-flex justify-content-center mb-4">
                <a href="index.php" class="app-brand-link d-flex justify-content-center">
                  <img src="assets/img/icons/unicons/logotipo_fiscalia.png" alt="Fiscalia_Huánuco" class="img-fluid" style="max-width: 250px;" />
                </a>
              </div>
              <!-- /Logo -->

              <!-- Texto de bienvenida centrado -->
              <div style="text-align: center;">
                <h4 class="mb-2">¡Bienvenido al sistema de soporte!</h4>
                <p class="mb-4" style="color: #566a7f;">Por favor, inicia sesión en tu cuenta y comienza la asistencia.</p>
              </div>

              <!-- Formulario de autenticación -->
              <form id="formAuthentication" class="mb-3" action="index.php" method="POST">
                <div class="mb-3">
                  <label for="email" class="form-label">Email o Usuario</label>
                  <input type="text" class="form-control" id="email" name="email-username" placeholder="Ingresa tu email o usuario" autofocus />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Contraseña</label>
                  </div>
                  <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Iniciar sesión</button>
                </div>                
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Modal de error (Bootstrap) -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered"> <!-- Centrado vertical -->
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="errorModalLabel">Error</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?php
            if ($error_message) {
                echo $error_message;
            }
            ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Mostrar el modal solo si hay un mensaje de error -->
    <script>
        <?php if ($error_message): ?>
            var myModal = new bootstrap.Modal(document.getElementById('errorModal'), {
                keyboard: false
            });
            myModal.show();
        <?php endif; ?>
    </script>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/js/menu.js"></script>
    
    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
