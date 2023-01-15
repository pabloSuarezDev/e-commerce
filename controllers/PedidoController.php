<?php
  require_once 'models/Pedido.php';

  class PedidoController {
    public function hacer() {
      require_once 'views/pedido/hacer.php';
    }

    public function add() {
      if(isset($_SESSION['identity'])) {
        //? Guardar datos en DB
        $usuario_id = $_SESSION['identity']->id; 
        $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false;
        $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;
        $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
        
        $stats = Utils::statsCarrito();
        $coste = $stats['total'];

        if($provincia && $localidad && $direccion) {
          $pedido = new Pedido();
          $pedido->setUsuarioID($usuario_id);
          $pedido->setProvincia($provincia);
          $pedido->setLocalidad($localidad);
          $pedido->setDireccion($direccion);
          $pedido->setCoste($coste);

          $save = $pedido->save();

          //? Guardar linea pedido
          $save_linea = $pedido->saveLinea();

          if($save && $save_linea) {
            $_SESSION['pedido'] = "completed";
          } else {
            $_SESSION['pedido'] = "failed";
          }
        } else {
          $_SESSION['pedido'] = "failed";
        }
      } else {
        header("location: ".BASE_URL."pedido/hacer");
      }
      header("location: ".BASE_URL."pedido/confirmado");
    }

    public function confirmado() {
      $identity = isset($_SESSION['identity']) ? $_SESSION['identity'] : false;

      $pedido = new Pedido();
      $pedido->setUsuarioID($identity->id);
      $pedido = $pedido->getOneByUser();
      
      $pedido_productos = new Pedido();
      $productos = $pedido_productos->getProductosByPedido($pedido->id);

      require_once 'views/pedido/confirmado.php';
    }

    public function misPedidos() {
      Utils::isIdentify();
      $identity = $_SESSION['identity'];

      //? Sacar los pedidos del usuario
      $pedido = new Pedido();
      $pedido->setUsuarioID($identity->id);
      $pedidos = $pedido->getAllByUser();

      require_once 'views/pedido/mis_pedidos.php';
    }

    public function detalle() {
      Utils::isIdentify();
      if(isset($_GET['id'])) {
        $id = $_GET['id'];

        //? Sacar el pedido
        $pedido = new Pedido();
        $pedido->setID($id);
        $pedido = $pedido->getOne();
      
        //? Sacar los productos
        $pedido_productos = new Pedido();
        $productos = $pedido_productos->getProductosByPedido($id);

        require_once 'views/pedido/detalle.php';
      } else {
        header("location: ".BASE_URL."pedido/misPedidos");
      }
    }

    public function gestion() {
      Utils::isAdmin();
      $identity = $_SESSION['identity'];

      //? Sacar los pedidos del usuario
      $pedido = new Pedido();
      $pedidos = $pedido->getAll();

      require_once 'views/pedido/mis_pedidos.php';
    }

    public function estado() {
      Utils::isAdmin();
      if(isset($_POST['pedido_id']) && isset($_POST['estado'])) {
        //? Recoger datos form
        $id = $_POST['pedido_id'];
        $estado = $_POST['estado'];

        //? Update del pedido
        $pedido = new Pedido();
        $pedido->setID($id);
        $pedido->setEstado($estado);
        $pedido->updateEstado();

        header("location: ".BASE_URL."pedido/detalle&id=".$id);
      } else {
        header("location: ".BASE_URL);
      }
    }
  }
?>