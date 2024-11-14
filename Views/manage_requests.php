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

    <title>Gestionar Solicitudes - Fiscalía de Huánuco</title>

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

                <li class="menu-item">
                    <a href="report_assistant.php" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-brain"></i>
                        <div data-i18n="Tables">AI Reportes</div>
                    </a>
                </li>

                <li class="menu-item active">
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
                ¡Hola! Bienvenido al módulo de<strong> Gestionar Solicitudes</strong>. Aquí puedes revisar y gestionar todas las solicitudes de la Fiscalía. ¡Tu gestión comienza ahora!
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

          <?php
            // Incluir archivo de conexión a la base de datos
            include('../config/conexion.php');

            // Consulta para obtener todos los problemas
            $query = "SELECT * FROM problemas";
            $stmt = $conexion->prepare($query);
            $stmt->execute();
            $problemas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Fiscalía de Huánuco /</span> Gestionar Solicitudes</h4>

                    <!-- Basic Bootstrap Table -->
                    <div class="card">
                        <h5 class="card-header">Gestión de Solicitudes</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table" id="usuariosTable">
                                <thead>
                                    <tr>
                                        <th>Nombre Usuario</th>
                                        <th>Destinatario</th>
                                        <th>Tipo de Problema</th>
                                        <th>Problema Descrito</th>
                                        <th>Correo Destinatario</th>
                                        <th>Fecha Creación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0" id="usuariosTableBody">
                                    <?php foreach ($problemas as $problema): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($problema['nombre_usuario']); ?></td>
                                            <td><?php echo htmlspecialchars($problema['destinatario']); ?></td>
                                            <td><?php echo htmlspecialchars($problema['tipo_problema']); ?></td>
                                            <td style="word-wrap: break-word; white-space: normal;"><?php echo htmlspecialchars($problema['problema_descrito']); ?></td>
                                            <td><?php echo htmlspecialchars($problema['correo_destinatario']); ?></td>
                                            <td><?php echo htmlspecialchars($problema['fecha_creacion']); ?></td>
                                            <td>
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#visualizarModal<?php echo $problema['id']; ?>">Visualizar</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- / Content -->
            </div>
            <!-- Content wrapper -->

            <?php foreach ($problemas as $problema): ?>
            <!-- Modal -->
            <div class="modal fade" id="visualizarModal<?php echo $problema['id']; ?>" tabindex="-1" aria-labelledby="visualizarModalLabel" aria-hidden="true">
                <!-- Modal Dialog centered -->
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="visualizarModalLabel">Detalles del Problema</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Nombre Usuario:</strong> <?php echo htmlspecialchars($problema['nombre_usuario']); ?></p>
                            <p><strong>Destinatario:</strong> <?php echo htmlspecialchars($problema['destinatario']); ?></p>
                            <p><strong>Tipo de Problema:</strong> <?php echo htmlspecialchars($problema['tipo_problema']); ?></p>
                            <p><strong>Problema Descrito:</strong> <?php echo htmlspecialchars($problema['problema_descrito']); ?></p>
                            <p><strong>Correo Destinatario:</strong> <?php echo htmlspecialchars($problema['correo_destinatario']); ?></p>
                            <p><strong>Fecha Creación:</strong> <?php echo htmlspecialchars($problema['fecha_creacion']); ?></p>

                            <?php if ($problema['imagen_adjunto']): ?>
                                <p><strong>Imagen Adjunto:</strong></p>
                                <!-- Contenedor para la imagen con tamaño fijo -->
                                <div class="image-container" style="width: 100%; height: 250px; background-color: #f0f0f0; display: flex; justify-content: center; align-items: center; overflow: hidden; border: 1px solid #ccc; border-radius: 10px;">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($problema['imagen_adjunto']); ?>" alt="Imagen" class="img-fluid" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                </div>
                                <!-- Botón para descargar la imagen (único) -->
                                <a href="data:image/jpeg;base64,<?php echo base64_encode($problema['imagen_adjunto']); ?>" download="imagen_<?php echo $problema['id']; ?>.jpg" class="btn btn-primary mt-3 w-auto d-block mx-auto">Descargar Imagen</a>
                            <?php else: ?>
                                <p>No hay imagen adjunta.</p>
                            <?php endif; ?>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <!-- Botones centrados y tamaño ajustado en una sola fila -->
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?php echo htmlspecialchars($problema['correo_destinatario']); ?>&su=<?php echo urlencode('Problema Reportado por ' . $problema['nombre_usuario']); ?>&body=<?php echo urlencode(
                                "Este correo está siendo enviado desde el sistema de la Fiscalía de Huánuco.\n\n" . 
                                "Nombre Usuario: " . $problema['nombre_usuario'] . "\n" . 
                                "Destinatario: " . $problema['destinatario'] . "\n" . 
                                "Tipo de Problema: " . $problema['tipo_problema'] . "\n" . 
                                "Problema Descrito: " . $problema['problema_descrito'] . "\n" . 
                                "Correo Destinatario: " . $problema['correo_destinatario'] . "\n" . 
                                "Fecha Creación: " . $problema['fecha_creacion'] . "\n\n" . 
                                "Saludos, \nFiscalía de Huánuco"
                            ); ?>" class="btn btn-primary mx-2">Enviar Correo</a>
                            <!-- Eliminar uno de los botones de descarga de imagen -->
                            <!-- <a href="data:image/jpeg;base64,<?php echo base64_encode($problema['imagen_adjunto']); ?>" download="imagen_<?php echo $problema['id']; ?>.jpg" class="btn btn-info mx-2">Descargar Imagen</a> -->
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

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
    <script src="../js/panel_users/index.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>
    <script src="../js/microphone.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
