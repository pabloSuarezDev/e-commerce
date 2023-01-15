<?php
  require_once 'views/layout/header.inc.php';
  require_once 'views/layout/sidebar.inc.php';

  function showErr() {
    $err = new ErrorController();
    $err->index();
  }

  if(isset($_GET['controller'])) {
    $controller_name = $_GET['controller']."Controller";
  } elseif(!isset($_GET['controller']) && !isset($_GET['action'])) {
      $controller_name = DEFAULT_CONTROLLER;
  } else {
    showErr();
    exit();
  }

  if(class_exists($controller_name)) {
    $controller = new $controller_name();
    
    if(isset($_GET['action']) && method_exists($controller, $_GET['action'])) {
      $action = $_GET['action'];
      $controller->$action();
    } elseif(isset($controller) && !isset($_GET['action'])) {
        $default_action = DEFAULT_ACTION;
        $controller->$default_action();
    } else {
      showErr();
      exit();
    }
  } else {
    showErr();
    exit();
  }

  //! En el archivo .htaccess (configuracion de apache) también manejamos el error
  //! por si una pagina no exite que redireccione a una pagida de error

  require_once 'views/layout/footer.inc.php';
?>