<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php'); // Redirigir al login si no está autenticado
    exit();
}

// Verificar si el usuario tiene el rol correcto
if ($_SESSION['rol'] != 'Administrador' && basename($_SERVER['PHP_SELF']) != 'dashboard.php' && basename($_SERVER['PHP_SELF']) != 'report_assistant.php' && basename($_SERVER['PHP_SELF']) != 'manage_requests.php') {
    header('Location: dashboard.php'); // Redirigir si no tiene acceso
    exit();
}
?>

<!DOCTYPE html>
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>AI Reportes - Fiscalía de Huánuco</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/icons/unicons/icon_fiscalia.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        
        <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="dashboard.php" class="app-brand-link d-flex justify-content-center">
                    <img src="../assets/img/icons/unicons/logotipo_fiscalia.png" alt="Fiscalía Huánuco" width="180" />
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
                <!-- Dashboard -->
                <li class="menu-item">
                    <a href="dashboard.php" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>

                <!-- Registrar Usuario (Solo para Administrador) -->
                <?php if ($_SESSION['rol'] == 'Administrador') { ?>
                <li class="menu-item">
                    <a href="register_user.php" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-user-plus"></i>
                        <div data-i18n="Tables">Registrar Usuario</div>
                    </a>
                </li>
                <?php } ?>

                <li class="menu-item active">
                    <a href="report_assistant.php" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-brain"></i>
                        <div data-i18n="Tables">AI Reportes</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="manage_requests.php" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-message-square-detail"></i>
                        <div data-i18n="Tables">Gestionar Solicitudes</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="../Views/logout.php" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-log-out"></i>
                        <div data-i18n="Tables">Cerrar Sesión</div>
                    </a>
                </li>
            </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
        <!-- Nav inicio -->
        <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Welcome Message with Slower Sound Animation using Bootstrap only -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <!-- Slower Sound Wave Animation with Bootstrap spinners -->
                  <div class="d-flex align-items-center me-2">
                    <i class="spinner-grow text-primary" role="status" style="width: 0.5rem; height: 0.5rem; animation-duration: 2s;"></i>
                    <i class="spinner-grow text-primary ms-1" role="status" style="width: 0.75rem; height: 0.75rem; animation-duration: 2s;"></i>
                    <i class="spinner-grow text-primary ms-1" role="status" style="width: 1rem; height: 1rem; animation-duration: 2s;"></i>
                  </div>
                  <!-- Welcome Text -->
                  <span class="text-muted">
                    ¡Hola! Bienvenido al módulo de<strong> AI Reportes</strong>. Usa tu voz para enviar reportes en tiempo real. ¡La IA está escuchando!
                  </span>
                </div>
              </div>
              <!-- /Welcome Message with Slower Sound Animation using Bootstrap only -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Microphone Button -->
                <li class="nav-item d-flex align-items-center">
                  <img id="microphone" src="../assets/img/icons/unicons/microphone.png" alt="Micrófono" style="width: 42px; height: 42px; cursor: pointer;" />
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown ms-3">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img src="../assets/img/avatars/profile.png" alt class="w-px-40 h-auto rounded-circle" />
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="../assets/img/avatars/profile.png" alt class="w-px-40 h-auto rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block"><?php echo $_SESSION['nombre']; ?></span>
                                        <small class="text-muted"><?php echo $_SESSION['rol']; ?></small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li><div class="dropdown-divider"></div></li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#profileModal">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">Mi Perfil</span>
                            </a>
                        </li>
                        <li><div class="dropdown-divider"></div></li>
                        <li>
                            <a class="dropdown-item" href="../Views/logout.php">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Cerrar Sesión</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>
          <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="fw-bold py-3 mb-4">
                    <span class="text-muted fw-light">Fiscalía de Huánuco /</span> AI Reportes
                </h4>

                <div class="row">
                    <!-- Instruction Manual (Left Side) -->
                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="card w-100">
                            <!-- Card Header -->
                            <div class="card-header" style="background-color: #566a7f; border-bottom: 1px solid #e0e0e0; text-align: center;">
                                <h5 class="mb-0" style="color: white;">Cómo Usar el Asistente Virtual</h5>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <ul class="list-unstyled"><br>
                                    <li class="mb-3">
                                        <strong>1. Inicia el Chat:</strong> El asistente comenzará pidiéndote tu nombre. Solo tienes que decirlo en voz alta para que lo registre y empiece el proceso.
                                    </li>
                                    <li class="mb-3">
                                        <strong>2. Destinatario:</strong> El asistente te preguntará a quién va dirigido el mensaje. Dile en voz alta a quién enviar el mensaje y el asistente se encargará del resto.
                                    </li>
                                    <li class="mb-3">
                                        <strong>3. Descripción del Problema:</strong> El asistente te pedirá que expliques brevemente el problema. Usará esta información para analizar y ofrecerte una solución.
                                    </li>
                                    <li class="mb-3">
                                        <strong>4. Enviar Mensajes:</strong> En este paso, el asistente te pedirá adjuntar una imagen. Sigue las recomendaciones para asegurarte de que todo esté correcto antes de enviarla.
                                    </li>
                                    <li class="mb-3">
                                        <strong>5. Consulta de Correo:</strong> El asistente te proporcionará los correos electrónicos relevantes para contactar según tu problema. Solo menciona el área a la que deseas contactar:
                                        <ul>
                                            <li><strong>Técnico:</strong> <a href="mailto:atenciodelacruzmiguelangel@gmail.com">atenciodelacruzmiguelangel@gmail.com</a></li>
                                            <li><strong>Sistemas:</strong> <a href="mailto:mpfnlima96@gmail.com">mpfnlima96@gmail.com</a></li>
                                            <li><strong>Base de Datos:</strong> <a href="mailto:ingenierobasedato@gmail.com">ingenierobasedato@gmail.com</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <strong>6. Resolución de Problemas:</strong> El asistente te dará soluciones rápidas y guiará con pasos sencillos.
                                    </li>
                                </ul>
                                <p><strong>Nota:</strong> Si el asistente no puede resolver tu problema, te conectará con un técnico humano para asistencia adicional.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Chatbot (Right Side) -->
                    <div class="col-md-8 d-flex align-items-stretch">
                        <div class="card w-100">
                            <!-- Header with Bot Avatar and Professional Layout -->
                            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0;">
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-secondary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px; font-weight: bold;">
                                        <i class="bi bi-robot"></i> <!-- Bot Icon -->
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Soporte Técnico</h5>
                                        <small class="text-muted">Asistente Virtual</small>
                                    </div>
                                </div>
                                <div class="status-indicator d-flex align-items-center">
                                    <span class="badge bg-success rounded-circle" style="width: 10px; height: 10px; margin-right: 5px;"></span>
                                    <small class="text-muted">En línea</small>
                                </div>
                            </div>

                            <!-- Chat Body -->
                            <div class="card-body chat-box" style="overflow-y: auto; padding: 15px;">
                                <!-- Chat Messages -->
                            </div>

                            <div class="card-footer d-flex justify-content-center align-items-center">
                                <form id="chatForm" class="d-flex align-items-center justify-content-center w-100" onsubmit="sendData(event)" method="POST" action="../models/M_Send_Problem.php" enctype="multipart/form-data">
                                    <!-- Button for Attach File -->
                                    <button type="button" class="btn btn-light me-2" onclick="document.getElementById('attachFile').click();">
                                        <i class="bi bi-paperclip me-2"></i>Adjuntar archivo
                                    </button>

                                    <!-- File Input (Hidden) -->
                                    <input type="file" class="dropdown-item" id="attachFile" style="display: none;" onchange="uploadFile()">

                                    <!-- Button for Microphone -->
                                    <button type="button" class="btn btn-light me-2" onclick="startRecognition()">
                                        <i class="bi bi-mic me-2"></i>Usar micrófono
                                    </button>

                                    <button type="button" class="btn btn-light me-2" onclick="reloadPage()">
                                        <i class="bi bi-x-circle me-2"></i>Limpiar
                                    </button>

                                    <!-- Button for Send -->
                                    <button type="submit" class="btn btn-light ms-2">
                                        <i class="bi bi-send me-2"></i>Enviar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Icons Dependency (Bootstrap Icons) -->
                <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
            </div>
            <!-- / Content -->
        </div>
        <!-- Content wrapper -->

        <!-- Modal de Perfil de Usuario -->
        <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" id="profileModalLabel">Perfil de Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formProfile">
                            <!-- Campos del perfil de usuario -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" value="<?php echo $_SESSION['nombre']; ?>" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="apellidos" class="form-label">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" value="<?php echo isset($_SESSION['apellidos']) ? $_SESSION['apellidos'] : 'No disponible'; ?>" disabled>
                                </div>
                            </div>
                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <label for="correo" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="correo" value="<?php echo $_SESSION['correo_electronico']; ?>" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label">Número de Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" value="<?php echo isset($_SESSION['telefono']) ? $_SESSION['telefono'] : 'No disponible'; ?>" disabled>
                                </div>
                            </div>
                            <div class="row g-3 mt-3">
                                <div class="col-md-12">
                                    <label for="rol" class="form-label">Rol</label>
                                    <input type="text" class="form-control" id="rol" value="<?php echo $_SESSION['rol']; ?>" disabled>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../js/panel_report_assistant/index.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>
    <script src="../js/microphone.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
