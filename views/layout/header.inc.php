<?php
  session_start();
  require_once 'auto/controllers_autoload.php';
  require_once 'config/DB.php';
  require_once 'config/parameters.php';
  require_once 'helpers/utils.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- STYLESHEET -->
  <link rel="stylesheet" href="<?=BASE_URL?>assets/css/styles.css">
  <title>Tienda Online</title>
</head>
<body>
  <div id="container">
    <!-- CABECERA -->
    <header id="header">
      <div id="logo">
        <img src="<?=BASE_URL?>assets/img/camiseta.png" alt="Camiseta Logo"/>
        <a href="<?=BASE_URL?>">
          Tienda de camisetas
      </a>
      </div>
    </header>
    <!-- MENU -->
    <?php $categorias = Utils::showCategorias(); ?>
    <nav id="menu">
      <ul>
        <li>
          <a href="<?=BASE_URL?>">Inicio</a>
        </li>
        <?php while($categoria = $categorias->fetch_object()): ?>
        <li>
          <a href="<?=BASE_URL?>categoria/ver&id=<?=$categoria->id?>"><?=$categoria->nombre;?></a>
        </li>
        <?php endwhile;?>
      </ul>
    </nav>
    <!-- CONTENIDO PRINCIPAL -->
    <div id="content">
