<?php
  class Utils {
    public static function deleteSession($session_name) {
      if(isset($_SESSION[$session_name])) {
        $_SESSION[$session_name] = null;
        unset($_SESSION[$session_name]);
      }

      return $session_name;
    }

    public static function isAdmin() {
      if(!isset($_SESSION['admin'])) {
        header("location: ".BASE_URL);
      } else { return true; }
    }

    public static function isIdentify() {
      if(!isset($_SESSION['identity'])) {
        header("location: ".BASE_URL);
      } else { return true; }
    }

    public static function showCategorias() {
      require_once 'models/Categoria.php';
      $categoria = new Categoria();
      $categorias = $categoria->getAll();

      return $categorias;
    }

    public static function listAllProducts($productos) {
      while($product = $productos->fetch_object()) {
        echo "<div class='product'>";
            if($product->imagen != null) {
            echo "<a href='".BASE_URL."producto/ver&id=".$product->id."'>";
              echo "<img class='thumb' src='".BASE_URL."uploads/images/".$product->imagen."' alt='".$product->nombre."' />";
            echo "</a>";
            } else {
            echo "<a href='".BASE_URL."producto/ver&id=".$product->id."'>";
              echo "<img class='thumb' src='assets/img/camiseta.png' alt='Producto destacado' />";
            echo "</a>";
          }
          echo "<a href='".BASE_URL."producto/ver&id=".$product->id."'>";
            echo "<h2>".$product->nombre."</h2>";
          echo "</a>";
          echo "<p>".$product->precio."</p>";
          echo "<a class='button' href='".BASE_URL."carrito/add&id=".$product->id."'>Comprar</a>";
        echo "</div>";
      }
    }

    public static function productsDetails($pedido, $productos) {
      if(isset($pedido)) {
        $value = "Pendiente";

        echo "<h3>Dirección de envío</h3>";
        echo "<p>Número de pedido: <strong>".$pedido->provincia."</strong></p>";
        echo "<p>Total a pagar: <strong>".$pedido->localidad."</strong></p>";
        echo "<p>Número de pedido: <strong>".$pedido->direccion."</strong></p>";
        echo "<br />";
        echo "<br />";
        echo "<h3>Datos del pedido</h3>";

        if($pedido->estado == "confirmed") {
          $value = "Pendiente";
        } elseif($pedido->estado == "preparation") {
          $value = "En Preparación";
        } elseif($pedido->estado == "ready") {
          $value = "Preparado para enviar";
        } elseif($pedido->estado == "sended") {
          $value = "Enviado";
        }

        echo "<p>Estado: <strong>".$value."</strong></p>";
        echo "<p>Número de pedido: <strong>".$pedido->id."</strong></p>";
        echo "<p>Total a pagar: <strong>".$pedido->coste."$</strong></p>";
        echo "<br />";

        if(isset($_SESSION['admin'])) {
          echo "<h3>Cambiar estado del pedido</h3>";
          echo "<form action='".BASE_URL."pedido/estado' method='post'>";
            echo "<input type='hidden' name='pedido_id' value='".$pedido->id."' />";
            echo "<select name='estado'>";
              echo "<option value='confirmed'>Pendiente</option>";
              echo "<option value='preparation'>En preparación</option>";
              echo "<option value='ready'>Preparado para enviar</option>";
              echo "<option value='sended'>Enviado</option>";
            echo "</select>";
            echo "<input type='submit' value='Cambiar estado' />";
          echo "</form>";
          echo "<br />";
        }
        echo "<table>";
          echo "<tr>";
            echo "<th>Imagen</th>";
            echo "<th>Nombre</th>";
            echo "<th>Precio</th>";
            echo "<th>Unidades</th>";
          echo "</tr>";
        while($producto = $productos->fetch_object()) {
          echo "<tr>";
            if($producto->imagen != null) {
            echo "<td>";
              echo "<img class='img_carrito' src='".BASE_URL."uploads/images/".$producto->imagen."' alt='".$producto->nombre."' />";
            echo "</td>";
            } else {
            echo "<td>";
              echo "<img class='img_carrito' src='".$producto->imagen."' alt='".$producto->nombre."' />";
            echo "</td>";
            }
            echo "<td>";
              echo "<a href='<?=BASE_URL?>producto/ver&id=<?=$producto->id?>'>".$producto->nombre."</a>";
            echo "</td>";
            echo "<td>".$producto->precio."</td>";
            echo "<td>".$producto->unidades."</td>";
          echo "</tr>";
        }
        echo "</table>";
      } elseif(isset($_SESSION['pedido']) && $_SESSION['pedido'] == "failed") {
        echo "<h1>Pedido fallido</h1>";
        echo "<p style='text-align: center;'>";
        echo "<strong class='alert_red'>Pedido fallido, introduce bien los datos</strong>";
        echo "</p>";
      } else {
        header("location: ".BASE_URL);
      }
    }

    public static function statsCarrito() {
      $stats = [
        "count" => 0,
        "total" => 0
      ];

      if(isset($_SESSION['carrito'])) {
        $stats['count'] = count($_SESSION['carrito']);
        
        foreach ($_SESSION['carrito'] as $producto) {
          $stats['total'] += $producto['producto']->precio * $producto['unidades'];
        }
      }

      return $stats;
    }
  }
?>