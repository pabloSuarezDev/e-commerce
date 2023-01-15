<?php
  require_once 'models/Categoria.php';
  require_once 'models/Producto.php';

  class CategoriaController {
    public function index() {
      Utils::isAdmin();

      $categoria = new Categoria();
      $categorias = $categoria->getAll();

      require_once 'views/layout/header.inc.php';
      require_once 'views/categoria/index.php';
    }

    public function ver() {
      if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $categoria = new Categoria();
        $categoria->setID($id);
        $categoria = $categoria->getOne();

        $producto = new Producto();
        $producto->setCategoriaID($id);
        $productos = $producto->getAllCategory();
      }

      require_once 'views/categoria/ver.php';
    }

    public function crear() {
      Utils::isAdmin();
      require_once 'views/categoria/crear.php';
    }

    public function save() {
      Utils::isAdmin();

      //? Guarda categoría en la base de datos
      if(isset($_POST) && isset($_POST['cname'])) {
        $categoria = new Categoria();
        $categoria->setNombre($_POST['cname']);
        $categoria->save();
      }
      
      header("location: ".BASE_URL."categoria/index");
    }
  }
?>