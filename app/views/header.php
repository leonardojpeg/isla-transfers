<?php
require_once __DIR__ . '/../../config/db.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Isla Transfers</title>
  <!-- Estilos -->
  <link rel="stylesheet" href="css/styls.css">
  <!-- BootStrap 5.3.5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <!-- Librería FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Icono Favicon -->
  <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand">ISLA TRANSFERS</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <?php session_start(); ?>

          <li class="nav-item">
            <?php if (isset($_SESSION['id_viajero'])): ?>
              <a class="nav-link" href="index.php?page=customerPanel">Panel de control</a>
            <?php elseif (isset($_SESSION['id_admin'])): ?>
              <a class="nav-link" href="index.php?page=adminPanel">Panel de control</a>
            <?php elseif (isset($_SESSION['id_hotel'])): ?>
              <a class="nav-link" href="index.php?page=corpPanel">Panel de control</a>
            <?php else: ?>
              <a class="nav-link" href="index.php?page=welcome">Panel de control</a>
            <?php endif ?>
          </li>

          <?php if (!isset($_SESSION['id_viajero']) && !isset($_SESSION['id_admin']) && !isset($_SESSION['id_hotel'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="index.php?page=register">Registro</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?page=login">Login</a>
            </li>
          <?php elseif (isset($_SESSION['id_admin'])): ?>
            <!-- Mostrar Registro solo si es admin -->
            <li class="nav-item">
              <a class="nav-link" href="index.php?page=bookingList">Lista reservas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?page=manageHotel">Gestión hotel</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?page=manageCar">Gestión vehículo</a>
            </li>
            <li>
              <a class="nav-link" href="index.php?page=register">Registro</a>
            </li>
          <?php endif; ?>

          <li class="nav-item dropdown">
            <?php if (isset($_SESSION['email'])): ?>
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?= htmlspecialchars($_SESSION['email']) ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <?php
                $editProfilePage = 'userEditProfile';
                if (isset($_SESSION['id_admin'])) {
                  $editProfilePage = 'adminEditProfile';
                }
                ?>
                <li><a class="dropdown-item" href="index.php?page=<?= $editProfilePage ?>">Editar perfil</a></li>
                <li><a class="dropdown-item" href="index.php?page=logout">Cerrar sesión</a></li>
              </ul>
            <?php else: ?>
              <a class="nav-link disabled" aria-disabled="true">Usuario</a>
            <?php endif; ?>
          </li>
        </ul>
      </div>
    </div>
  </nav>