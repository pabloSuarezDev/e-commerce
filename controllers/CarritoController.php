<?php
  require_once 'models/Producto.php';

  class CarritoController {
    public function index() {
      if(isset($_SESSION['carrito']) && count($_SESSION['carrito']) >= 1) {
        $carrito = $_SESSION['carrito'];
      } else {
        $carrito = [];
      }
      require_once 'views/carrito/index.php';
    }

    public function add() {
      if(isset($_GET['id'])) {
        $producto_id = $_GET['id'];
      } else {
        header("location: ".BASE_URL);
      }

      if(isset($_SESSION['carrito'])) {
        $carrito = $_SESSION['carrito'];
        $counter = 0;

        foreach ($carrito as $indice => $elemento) {
          if($elemento['id_producto'] == $producto_id) {
            $_SESSION['carrito'][$indice]['unidades']++;
            $counter++;
          }
        }
      } 

      if(!isset($counter) || $counter == 0) {
        $producto = new Producto();
        $producto->setID($producto_id);
        $prod = $producto->getOne();

        //? Añadir al carrito
        if(is_object($prod)) {
          //? Añadimos un elemento al carrito con un [] es decir que sera un array
          $_SESSION['carrito'][] = [
            "id_producto" => $prod->id,   
            "precio" => $prod->precio,
            "unidades" => 1,
            "producto" => $prod
          ];
        }
        header("location: ".BASE_URL."carrito/index");
      }

      require_once 'views/carrito/index.php';
    }

    public function up() {
      if(isset($_GET['index'])) {
        $index = $_GET['index'];
        $_SESSION['carrito'][$index]['unidades']++;
        header("location: ".BASE_URL."carrito/index");
      }
    }

    public function down() {
      if(isset($_GET['index'])) {
        $index = $_GET['index'];
        $_SESSION['carrito'][$index]['unidades']--;

        if($_SESSION['carrito'][$index]['unidades'] == 0) {
          unset($_SESSION['carrito'][$index]);
        }

        if(!isset($_SESSION['carrito'][0])) {
          unset($_SESSION['carrito']);
        }
        header("location: ".BASE_URL."carrito/index");
      }
    }

    public function remove() {
      if(isset($_GET['index'])) {
        $index = $_GET['index'];
        unset($_SESSION['carrito'][$index]);
        header("location: ".BASE_URL."carrito/index");
      }
    }

    public function deleteAll() {
      unset($_SESSION['carrito']);
      header("location: ".BASE_URL."carrito/index");
    }
  }
?>