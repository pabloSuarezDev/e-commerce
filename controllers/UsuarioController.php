<?php
  require_once 'models/Usuario.php';
  
  class UsuarioController {
    public function index() {
      require_once 'views/usuario/destacados.php';
    }

    public function registro() {
      require_once 'views/usuario/registro.php';
    }
  
    public function save() {
      if(isset($_POST)) {
        $name = isset($_POST['fname']) ? $_POST['fname']: false;
        $surnames = isset($_POST['surnames']) ? $_POST['surnames']: false;
        $email = isset($_POST['email']) ? $_POST['email']: false;
        $password = isset($_POST['password']) ? $_POST['password']: false;

        if($name && $surnames && $email && $password) {
          $usuario = new Usuario();

          $usuario->setName($name);
          $usuario->setSurnames($surnames);
          $usuario->setEmail($email);
          $usuario->setPassword($password);

          $save = $usuario->save();

          if($save) {
            $_SESSION['register'] = "completed";
          } else {
            $_SESSION['register'] = "failed";
          }
        } else {
          $_SESSION['register'] = "failed";
        }
      } else {
        $_SESSION['register'] = "failed";
      }
      header("location: ".BASE_URL."usuario/registro");
    }

    public function login() {
      if(isset($_POST)) {
        //* Identificar usuario
        //? Consulta a la base de datos
        $usuario = new Usuario;
        $usuario->setEmail($_POST['email']);
        $usuario->setPassword($_POST['password']);
        
        $identity = $usuario->login();

        //? Crear la sesión del usuario
        if(is_object($identity)) {
          $_SESSION['identity'] = $identity;

          if($identity->rol == "admin") {
            $_SESSION['admin'] = true;
          }
        } else {
          $_SESSION['error_login'] = "Identificación fallida";
        }
      }
      header("location: ".BASE_URL);
    }

    public function logout() {
      if(isset($_SESSION['identity'])) {
        $_SESSION['identity'] = null;
        unset($_SESSION['identity']);
      }

      if(isset($_SESSION['admin'])) {
        $_SESSION['admin'] = null;
        unset($_SESSION['admin']);
      }

      header("location: ".BASE_URL);
    }
  }
?>