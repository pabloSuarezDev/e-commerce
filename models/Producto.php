<?php
  class Producto {
    private $id;
    private $categoria_id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;
    private $oferta;
    private $fecha;
    private $imagen;
    private $db;

    public function __construct() {
      $this->db = DB::connect();
    }

    public function getID() {
      return $this->id;
    }
    
    public function getCategoriaID() {
      return $this->categoria_id;
    }

    public function getNombre() {
      return $this->nombre;
    }

    public function getDescripcion() {
      return $this->descripcion;
    }

    public function getPrecio() {
      return $this->precio;
    }

    public function getStock() {
      return $this->stock;
    }

    public function getOferta() {
      return $this->oferta;
    }

    public function getFecha() {
      return $this->fecha;
    }

    public function getImagen() {
      return $this->imagen;  
    }

    public function setID($id) {
      $this->id = $id;
    }

    public function setCategoriaID($categoria_id) {
      $this->categoria_id = $this->db->real_escape_string($categoria_id);
    }

    public function setNombre($nombre) {
      $this->nombre = $this->db->real_escape_string($nombre);
    }

    public function setDescripcion($descripcion) {
      $this->descripcion = $this->db->real_escape_string($descripcion);
    }

    public function setPrecio($precio) {
      $this->precio = $this->db->real_escape_string($precio);
    }

    public function setStock($stock) {
      $this->stock = $this->db->real_escape_string($stock);
    }

    public function setFecha($fecha) {
      $this->fecha = $this->db->real_escape_string($fecha);
    }

    public function setImagen($imagen) {
      $this->imagen = $this->db->real_escape_string($imagen);
    }

    public function getAll() {
      $productos = $this->db->query("SELECT * FROM productos ORDER BY id DESC;");
      return $productos;
    }

    public function getAllCategory() {
      $sql = "SELECT p.*, c.nombre AS 'catnombre' FROM productos p 
              INNER JOIN categorias c ON c.id = p.categoria_id
              WHERE p.categoria_id = {$this->getCategoriaID()}
              ORDER BY id DESC
              ;";

      $productos = $this->db->query($sql);
      return $productos;
    }

    public function getRandom($limit) {
      $productos = $this->db->query("SELECT * FROM productos ORDER BY RAND() LIMIT $limit;");
      return $productos;
    }

    public function getOne() {
      $productos = $this->db->query("SELECT * FROM productos WHERE id={$this->getID()};");
      return $productos->fetch_object();
    }

    public function save() {
      $sql = "INSERT INTO productos VALUES (
                null, 
                {$this->getCategoriaID()},
                '{$this->getNombre()}',
                '{$this->getDescripcion()}',
                {$this->getPrecio()},
                {$this->getStock()},
                null,
                CURDATE(),
                '{$this->getImagen()}'
              );";

      $save = $this->db->query($sql);
      
      $result = false;
      if($save) {
        $result = true;
      }

      return $result;
    }

    public function editar() {
      $sql = "UPDATE productos SET
                id={$this->getID()}, 
                categoria_id={$this->getCategoriaID()},
                nombre='{$this->getNombre()}',
                descripcion='{$this->getDescripcion()}',
                precio={$this->getPrecio()},
                stock={$this->getStock()},
                oferta=null,
                fecha=CURDATE()";
           
      if($this->getImagen() != null) {
        $sql .= ", imagen='{$this->getImagen()}'";
      }

      $sql .= " WHERE id={$this->getID()};";

      $save = $this->db->query($sql);
      
      $result = false;
      if($save) {
        $result = true;
      }

      return $result;
    }

    public function delete() {
      $sql = "DELETE FROM productos WHERE id='{$this->id}'";

      $delete = $this->db->query($sql);
      
      $result = false;
      if($delete) {
        $result = true;
      }

      return $result;
    }
  }
?>