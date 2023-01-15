<?php
  require_once 'models/Producto.php';

  class ProductoController {
    public function index() {
      $producto = new Producto();
      $productos = $producto->getRandom(6);

      //? Renderizar vista
      require_once 'views/producto/destacados.php';
    }

    public function ver() {
      if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $producto = new Producto();
        $producto->setID($id);
        $prod = $producto->getOne();
      }

      require_once 'views/producto/ver.php';
    }

    public static function gestion() {
      Utils::isAdmin();
      $producto = new Producto();
      $productos = $producto->getAll();
      
      require_once 'views/producto/gestion.php';
    }

    public function crear() {
      Utils::isAdmin();
      require_once 'views/producto/crear.php'; 
    }

    public function save() {
      Utils::isAdmin();

      //? Añadir productor en la base de datos
      if(isset($_POST)) {
          
        $categoria_id = isset($_POST['category']) ? $_POST['category'] : false;
        $nombre = isset($_POST['pname']) ? $_POST['pname'] : false; 
        $descripcion = isset($_POST['desc']) ? $_POST['desc'] : false; 
        $precio = isset($_POST['price']) ? $_POST['price'] : false; 
        $stock = isset($_POST['stock']) ? $_POST['stock'] : false;  

        if($nombre && $descripcion && $precio && $stock && $categoria_id) {
          $producto = new Producto();
          $producto->setNombre($nombre);
          $producto->setDescripcion($descripcion);
          $producto->setPrecio($precio);
          $producto->setStock($stock);
          $producto->setCategoriaID($categoria_id);

          //? Guardar la imagen
          if(isset($_FILES['image'])) {
            $file = isset($_FILES['image']) ? $_FILES['image'] : false; 
            $filename = isset($file) ? $file['name'] : false;
            $mimetype = isset($file) ? $file['type'] : false;

            if($mimetype == "image/jpg" || $mimetype == "image/jpeg" || $mimetype = "image/png" || $mimetype == "image/gif") {
              if(!is_dir('uploads/images')) {
                mkdir('uploads/images', 0777);
              }

              move_uploaded_file($file['tmp_name'], "uploads/images/".$filename);
              $producto->setImagen($filename);
            }
          }

          if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $producto->setID($id);

            $save = $producto->editar();
          } else {
            $save = $producto->save();
          }
          
          if($save) {
            $_SESSION['producto'] = "completed";
          } else {
            $_SESSION['producto'] = "failed";
          }
        } else {
          $_SESSION['producto'] = "failed";
        }
      } else {
        $_SESSION['producto'] = "failed";
      }

      header("location: ".BASE_URL."producto/gestion");
    }

    public function editar() {
      Utils::isAdmin();

      if(isset($_GET['id'])) {
        require_once 'models/Categoria.php';

        $categoria = new Categoria();
        $categorias = $categoria->getAll();

        $id = $_GET['id'];
        $edit = true;

        $producto = new Producto();
        $producto->setID($id);
        $prod = $producto->getOne();

        require_once 'views/producto/crear.php';
      } else {
        header("location: ".BASE_URL."producto/gestion");
      }
    }

    public function eliminar() {
      Utils::isAdmin();

      if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $producto = new Producto();
        $producto->setID($id);

        $delete = $producto->delete();

        if($delete) {
          $_SESSION['delete'] = "completed";
        } else {
          $_SESSION['delete'] = "failed";
        }
      } else {
        $_SESSION['delete'] = "failed";
      }

      header("location: ".BASE_URL."producto/gestion");
    }
  }
?>